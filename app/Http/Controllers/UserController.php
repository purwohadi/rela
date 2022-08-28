<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, UserGroup};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResources;
use Illuminate\Contracts\Session\Session;
use Diskominfotik\Downloadable\Facades\Downloadable;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserController extends Controller
{
  protected $user;

  /**
   * UserController constructor.
   *
   * @param UserRepositoryInterface $user
   */
  public function __construct(UserRepositoryInterface $user)
  {
    $this->user = $user;
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function search(Request $request)
  {
    return $this->user->search($request);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function me()
  {
    return $this->user->get(auth()->user()->v_userid);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function show($id, User $user)
  {
    $show = $user->findBySlug($id);
    return new UserResources($show);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $find = User::where('v_userid', $request->user_id)->first();
    if($find) {
      return $this->redirectResponse($request, 'Pengguna Sudah Ada!', 'error', 'duplicate');
    }

    $input = $request->only(['user_id', 'password', 'nama', 'status', 'group']);
    $user = $this->user->save($input);

    $type = $user ? 'success' : 'error';
    return $this->redirectResponse($request, trans("user.actions.store.{$type}"), $type, $user);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    $input = $request->only(['user_id', 'password', 'nama', 'status', 'group']);
    $user = $this->user->update($request->user_id, $input);

    $type = $user ? 'success' : 'error';
    return $this->redirectResponse($request, trans("user.actions.update.{$type}"), $type, $user);
  }

  /**
   * Delete user
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function drop(Request $request)
  {
    $user = $this->user->delete($request->slug);
    $type = $user ? 'success' : 'error';
    return $this->redirectResponse($request, trans("user.actions.drop.{$type}"), $type);
  }

  public function upload(Request $request)
  {
    $id = auth()->user()->v_userid;
    $user = User::find($id);
    $uploaded = $this->user->save($user, $request->input(), $request->file('photo'));
    $type = !$uploaded ? 'error' : 'success';
    return $this->redirectResponse($request, trans("user.actions.upload.{$type}"), $type, $uploaded);
  }

  public function syncRole(Request $request)
  {
    $synced = $this->user->sync_role($request->username, $request->role_name);
    $type = !$synced ? 'error' : 'success';
    return $this->redirectResponse($request, trans("user.actions.sync.{$type}"), $type, $synced);
  }

  public function changePassword(Request $request)
  {
    $change = $this->user->updatePassword($request);
    $type = !$change ? 'error' : 'success';
    return $this->redirectResponse($request, trans("user.actions.password.{$type}"), $type, $change);
  }

  public function impersonate(Request $request, $role)
  {
      $id = auth()->user()->v_userid;
      $user_id = $id.'-'.$role;
      $userFind = UserGroup::where('v_userid', $user_id)->first();
      if (!$userFind) {
        return response()->json('NRK Tidak Ada!', 404);
      } else {
        $user = $userFind->user;
        auth()->user()->impersonate($user);
        $newUser = $this->user->login(auth()->user());
        return new UserResources($newUser);
      }
  }

  public function leaveImpersonate(Request $request)
  {
      auth()->user()->leaveImpersonation();
      $newUser = $this->user->login(auth()->user());

      return response()->json($newUser, 200);
    }

    /**
   * Show Data Profil Name a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function getDataProfil(Request $request)
  {
    $wilayah  = explode('-', auth()->user()->v_userid)[0];

    if ($wilayah == 'utara') {
      $vKondisi = '(substr(v_kode_skpd,0,1) = 2 or substr(v_kode_skpd,0,2) = 11)';
    } elseif ($wilayah == 'barat') {
      $vKondisi = 'substr(v_kode_skpd,0,1) = 3';
    } elseif ($wilayah == 'selatan') {
      $vKondisi = 'substr(v_kode_skpd,0,1) = 4';
    } elseif ($wilayah == 'timur') {
      $vKondisi = 'substr(v_kode_skpd,0,1) = 5';
    } elseif ($wilayah == 'pusat') {
      $vKondisi = 'substr(v_kode_skpd,0,2) = 10';
    } else {
      $vKondisi = "tm_users.v_userid = '{$request->user_id}'";
    }

    $find = User::query()
    ->join('tr_skpd', function ($join) use ($vKondisi, $wilayah) {
        $join->on('tr_skpd.v_unit_id', '=', 'tm_users.v_userid');
        if ($wilayah != 'hd') {
          $join->whereRaw($vKondisi);
        }
    });

    $find = $find->where('v_userid', $request->user_id)->first();

    return $find;
  }

  public function changePasswordAdminPdukpd(Request $request)
  {
    $change = $this->user->updatePasswordAdminPdukpd($request);
    $type = !$change ? 'error' : 'success';
    return $this->redirectResponse($request, trans("user.actions.password.{$type}"), $type, $change);
  }

  public function checkCurrentPassword(Request $request)
  {
    $credentials = json_decode(decrypt_params($request->credentials));
    $request->merge([
      'user_id' => $credentials->user_id,
      'password' => $credentials->password,
    ]);

    $plain = $request->password;
    $find = User::where('v_userid', $request->user_id)->first();

    if (md5($plain) == $find->v_userpass) {
      return json_encode([
        'valid' => true,
      ]);
    }
    $check = Hash::check($plain, config('pwdskt.password_hash')) || Hash::check($plain, $find->v_userpass);
    return json_encode([
      'valid' => $check,
    ]);
  }

}
