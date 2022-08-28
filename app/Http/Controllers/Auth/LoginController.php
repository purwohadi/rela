<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Rules\CheckCaptcha;
use Illuminate\Http\Request;
use App\Rules\CheckUserExist;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Repositories\Contracts\UserRepositoryInterface;

class LoginController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Login Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles authenticating users for the application and
  | redirecting them to your home screen. The controller uses a trait
  | to conveniently provide its functionality to your applications.
  |
  */

  use AuthenticatesUsers;

  /**
   * Where to redirect users after login.
   *
   * @var string
   */
  protected $redirectTo = RouteServiceProvider::HOME;

  /**
   * Get the maximum number of attempts to allow.
   *
   * @return int
   */
  protected $maxAttempts;

  /**
   * Increment the login attempts for the user.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return void
   */
  protected $decayMinutes;

  /**
   * @var \App\Repositories\Contracts\UserRepositoryInterface
   */
  protected $user;

  /**
   * Login username to be used by the controller.
   *
   * @var string
   */
  protected $username;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(UserRepositoryInterface $user)
  {
    $this->user = $user;
    $this->username = $this->findUsername();
    $this->maxAttempts = config('app.max_attemps');
    $this->decayMinutes = config('app.decay_minutes');
    $this->middleware('guest')->except('logout');
  }

  /**
   * set username column
   *
   * @return column for login check
   */
  public function username()
  {
    return $this->username;
  }

  /**
   * Get the login username to be used by the controller.
   *
   * @return string
   */
  public function findUsername()
  {
    $login = request('username');
    $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    request()->merge([$fieldType => $login]);
    return $fieldType;
  }

  /**
   * Get the needed authorization credentials from the request.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return array
   */
  protected function credentials(Request $request)
  {
    // $tes = $request->only($this->username(), 'password');
    return [
      'v_userid' => $request->{$this->username()},
      'v_userpass' => $request->password,
      'e_user_enable' => 1
    ];
  }

  /**
   * Attempt to log the user into the application.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return bool
   */
  protected function attemptLogin(Request $request)
  {
    return $this->guard()->attempt(
      $this->credentials($request),
      $request->filled('remember')
    );
  }

  /**
   * Send the response after the user was authenticated.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  protected function sendLoginResponse(Request $request)
  {
    $request->session()->regenerate();

    $this->clearLoginAttempts($request);

    return $this->authenticated($request, $this->guard()->user())
      ?: redirect()->intended($this->redirectPath());
  }

  /**
   * The user has been authenticated.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  mixed  $user
   * @return mixed
   */
  protected function authenticated(Request $request, $user)
  {
    // set session
    $this->user->login($user);

    // sending response as json
    if ($request->ajax()) {
      return response()->json(['status' => 'success']);
    }
  }

  /**
   * Handle a login request to the application.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  public function login(Request $request)
  {
    $credentials = json_decode(decrypt_params($request->credentials));

    $request->merge([
      'username' => $credentials->username,
      'password' => $credentials->password,
      'captcha' => $credentials->captcha
    ]);

    $this->validateLogin($request);

    // If the class is using the ThrottlesLogins trait, we can automatically throttle
    // the login attempts for this application. We'll key this by the username and
    // the IP address of the client making these requests into this application.
    if (
      method_exists($this, 'hasTooManyLoginAttempts') &&
      $this->hasTooManyLoginAttempts($request)
    ) {
      $this->fireLockoutEvent($request);

      return $this->sendLockoutResponse($request);
    }

    if ($this->attemptLogin($request)) {
      // then remove captcha session when success validated
      if (session()->has('captcha')) {
        session()->remove('captcha');
      }

      return $this->sendLoginResponse($request);
    }

    // If the login attempt was unsuccessful we will increment the number of attempts
    // to login and redirect the user back to the login form. Of course, when this
    // user surpasses their maximum number of attempts they will get locked out.
    $this->incrementLoginAttempts($request);

    return $this->sendFailedLoginResponse($request);
  }


  /**
   * Validate the user login request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return void
   *
   * @throws \Illuminate\Validation\ValidationException
   */

  protected function validateLogin(Request $request)
  {
    $needValidate = [
      $this->username() => ['required', 'string', new CheckUserExist],
      'password' => ['required', 'string', new CheckUserExist($request->{$this->username()})],
    ];

    if (app()->env == 'production') {
      $needValidate['captcha'] = ['required', new CheckCaptcha];
    }

    $request->validate($needValidate);
  }

  /**
   * Validate the user login request with custom request/api based on
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  protected function userCheck(Request $request, $callback = null)
  {
    $passwordField = config('pwdskt.password_fieldname');
    $user = User::where('v_userid', $request->nrk)
      ->where('e_user_enable', 1)
      ->first();

    if (!is_null($callback)) {
      $temp = $callback($user);
      if ($temp !== true) return $temp;
    }

    if ($user) {
      $check = false;
      $plain = base64_decode($request->password);

      //check if password md5
      if (md5($plain) == $user->{$passwordField}) {
        $check = true;
      } else {
        $check = Hash::check($plain, $user->v_userpass);
      }

      return $check ? response()->json([
        'status'  => 'success',
        'hasil' => 1,
        'message' => 'User Authorized',
      ]) : response()->json([
        'status'  => 'error',
        'hasil' => 0,
        'message' => 'User Unauthorized',
      ], 401);
    }

    return response()->json([
      'status'  => 'error',
      'hasil' => 0,
      'message' => 'User Not Found',
    ], 401);
  }

  /**
   * Method for eabsensi user login check
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function userAuthorize(Request $request)
  {
    return $this->userCheck($request);
  }

  /**
   * Method for temporary use
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function tempUserAuthorize(Request $request)
  {
    $unitAllowed = explode(',', env('API_UNIT_ALLOWED', null));
    if (is_null(env('PROD_URL')) || mb_strpos($request->url(), env('PROD_URL'), 0) !== false) {
      return response()->json([
        'success' => false,
        'errors' => 'Forbidden'
      ], JsonResponse::HTTP_FORBIDDEN);
    }

    return $this->userCheck($request, function($user) use ($unitAllowed) {
      $userWithDataPegawai = $user->load('pegawai');
      $latestPegawai = collect($userWithDataPegawai->pegawai)->last();
      if (!in_array($latestPegawai->v_kolok, $unitAllowed)) {
        return response()->json([
          'success' => false,
          'errors' => 'Forbidden'
        ], JsonResponse::HTTP_FORBIDDEN);
      }

      return true;
    });
  }
}
