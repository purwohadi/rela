<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Password Reset Controller
  |--------------------------------------------------------------------------
  |
  | This controller is responsible for handling password reset requests
  | and uses a simple trait to include this behavior. You're free to
  | explore this trait and override any methods you wish to tweak.
  |
  */

  use ResetsPasswords;

  /**
   * Where to redirect users after resetting their password.
   *
   * @var string
   */
  protected $redirectTo = RouteServiceProvider::HOME;

  public function showResetPasswordForm($token, Request $request){
    $isExpired = $this->isExpired($request->email, $token);
    return view('layouts.reset', ['token' => $token, 'expired' => $isExpired]);
  }

  public function isExpired($email, $token)
  {
    $check = DB::table('password_resets')->where('email', $email)->where('token', $token)->first();
    if($check) {
      $created = Carbon::parse($check->created_at);
      $expired = $created->diffInSeconds(Carbon::now()) > intval(config('app.pass_expired'));
      return $expired;
    }
    return 'invalid';
  }

  public function passwordUpdate(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required|min:8|confirmed',
      'password_confirmation' => 'required'
    ]);

    $updatePassword = DB::table('password_resets')
    ->where([
      'email' => $request->email,
      'token' => $request->token
    ])
    ->first();

    if (!$updatePassword) {
      return [
        'status' => 'error',
        'message' => "Token tidak valid!"
      ];
    }
    else {
      $isExpired = $this->isExpired($request->email, $request->token);
      if(!$isExpired) {
        $pegawai = DB::table('vw_pers_pegawai')->where('email', $request->email)->first();
        if($pegawai) {
          $user = User::where('v_userid', $pegawai->nrk)
          ->update(['v_userpass' => Hash::make($request->password)]);

          if($user) {
            DB::table('password_resets')->where(['email' => $request->email])->delete();
          }
        }
        else {
          return [
            'status' => 'error',
            'message' => "Pegawai tidak ditemukan!"
          ];
        }
      }
      else {
        return [
          'status' => 'error',
          'message' => "Token telah kadaluwarsa!"
        ];
      }
    }

    return [
      'status' => 'success',
      'message' => "Password Berhasil diubah"
    ];
  }
}
