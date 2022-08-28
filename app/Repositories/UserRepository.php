<?php

namespace App\Repositories;

use App\Utils\UserInfo;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\UserGroup;
use App\Http\Resources\UserResources;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
  protected $user;
  protected $user_group;

  protected $columns = [
    'user_id' => 'v_userid',
    'username' => 'v_username',
    'status' => 'e_user_enable',
    'last_update_password' => 'd_last_update_pass',
  ];

  /**
   * User constructor
   *
   * @param User $user
   * @param UserGroup $user_group
   */
  public function __construct(
    User $user,
    UserGroup $user_group
  ) {
    $this->user = $user;
    $this->user_group = $user_group;
  }

  /**
   * Update last_logged_in field
   *
   * @param Authenticatable $user
   * @throws \App\Exceptions\GeneralException
   * @return \App\Models\User
   */
  public function login(Authenticatable $user)
  {
    $userInfo = new UserInfo($user);
    $user->d_last_logged_in = Carbon::now();
    if (!$user->save()) throw new GeneralException(__('auth.users.update'));

    session([
      'roles' => $userInfo->groups()->pluck('v_group_name'),
      'current_opd_id' => $userInfo->groups()->pluck('v_opd_id'),
      'permissions' => $userInfo->features()->pluck('v_alias'),
      'latest_thbl' => $userInfo->latestThbl(),
      'current_kolok' => $userInfo->getKodeLokasi(),
      'current_kojab' => $userInfo->getCurrentKodeJabatan(),
      'current_spmu' => $userInfo->getKodeSpm(),
      'current_eselon' => $userInfo->getCurrentEselon(),
      'current_nama' => $userInfo->getCurrentNama(),
      'current_nip' => $userInfo->getCurrentNIP(),
      'user_info' => $userInfo,
      'user_id' => $user->v_userid
    ]);
    return $user;
  }

  /**
   * Get's a user by it's ID
   *
   * @param int
   * @return collection
   */
  public function get($user_id)
  {
    return $this->user->find($user_id);
  }

  /**
   * Get's all users.
   *
   * @return mixed
   */
  public function all()
  {
    return $this->user->all();
  }

  /**
   * Get's all users.
   *
   * @return mixed
   */
  public function search(Request $request)
  {
    if ($request->sort_by == null) {
      $query = $this->user->orderBy($this->columns['user_id'], 'asc');
    } else {
      $query = $this->user->orderBy($this->columns[$request->sort_by], $request->sort_desc);
    }

    if ($request->has('search') && strlen(trim($request->search)) > 0) {
        $mapped = $this->columns;
        $query->where(function($sql) use ($request, $mapped) {
          $idx = 0;
          foreach ($request->column_filters as $column) {
            $clause = $idx == 0 ? 'where' : 'orWhere';
            $sql->{$clause}(DB::raw("upper({$mapped[$column]})"), 'like', '%' . strtoupper($request->search) . '%');
            ++$idx;
          }
        });
    }

    if ($request->has('filter_select')) {
        $query->where(function($sql) use ($request) {
          $clause = 'where';
          $sql->{$clause}(DB::raw("upper(e_user_enable)"), $request->filter_select);
        });
    }

    if (!auth()->user()->is_admin) {
      $query->whereHas('pegawai', function ($q) {
        if (auth()->user()->is_admin_skpd) {
          $q->where('v_spmu', session()->get('current_spmu'));
        }

        if (auth()->user()->is_admin_ukpd || auth()->user()->is_common_user) {
          $q->where('v_kolok', session()->get('current_kolok'));
        }
      });
    }

    return UserResources::collection($query->paginate($request->limit));
  }

  /**
   * Save a user
   *
   * @param array $input
   */
  public function save(array $input)
  {
    $user_id = auth()->user()->v_userid;
    try {
      $user = $this->user->create([
        'v_userid' => $input['user_id'],
        'v_userpass' => bcrypt($input['password']),
        'v_username' => $input['nama'],
        'e_user_enable' => $input['status'],
        'v_created_by' => $user_id
      ]);

      $group = $input['group'];
      if($user) {
        if(!empty($group)) {
          $data_group = array();
          foreach ($group as $key => $value) {
            array_push($data_group, array(
                'v_userid'=>$input['user_id'],
                'v_group_id'=>$value['value'],
                'v_created_by' => $user_id,
                'dt_created_at' => Carbon::now())
            );
            createLog(config('tables.master.user_group'), 'INS', collect($data_group)->sortKeys());
          }
          UserGroup::insert($data_group);
        }
      }

      createLog(config('tables.master.users'), 'INS', collect($user)->sortKeys());
      return true;
    } catch (\Throwable $th) {
      Log::error($th);
      return false;
    }
  }

  /**
   * Updates a users.
   *
   * @param int
   * @param array
   */
  public function update($id, array $input)
  {
    $user_id = auth()->user()->v_userid;
    try {
      	$user = $this->user->where('v_userid', $id)->first();
      	if (!isset($input['password']) || $input['password'] == null) {
			$user->update([
			'v_username' => $input['nama'],
			'e_user_enable' => $input['status'],
			'v_updated_by' => $user_id
			]);
		} 
		else 
		{
			$user->update([
			'v_username' => $input['nama'],
			'v_userpass' => bcrypt($input['password']),
			'e_user_enable' => $input['status'],
			'v_updated_by' => $user_id
			]);
		}

		$group = $input['group'];
		if(!empty($group)) {
			$this->user_group->where('v_userid', $user->v_userid)->delete();

			$data_group = array();
			foreach ($group as $key => $value) {
				array_push($data_group, array(
					'v_userid'=>$input['user_id'],
					'v_group_id'=>$value['value'],
					'v_created_by' => $user_id,
					'dt_created_at' => Carbon::now())
				);
				createLog(config('tables.master.user_group'), 'UPD', collect($data_group)->sortKeys());
			}

			$this->user_group->insert($data_group);
		}
		createLog(config('tables.master.users'), 'UPD', collect($user)->sortKeys());

		return true;
    } catch (\Throwable $th) {
		Log::error($th);
		return false;
    }
  }

  /**
   * Deletes a user.
   *
   * @param string
   */
  public function delete($slug)
  {
    try {
      $user = $this->user->where('v_userid', $slug)->first();
      if ($user) {
        $user->delete();
        // dd(getQueries($user));
        $user_group = $this->user_group->where('v_userid', $user->v_userid)->delete();

        createLog(config('tables.master.users'), 'DEL', collect($user)->sortKeys());
        createLog(config('tables.master.user_group'), 'DEL', collect($user)->sortKeys());
      }

      return true;
    } catch (\Throwable $th) {
      return false;
    }
  }

  /**
   * Upload user's avatar.
   *
   * @param string $user_id
   * @param file $file
   */
  public function upload_avatar(String $user_id, UploadedFile $file)
  {
    $uploaded = DB::transaction(function () use ($user_id, $file) {
      $user = User::find($user_id);
      $currentAvatar = $user->getMedia('avatar image')->first();
      // Delete current file if replaced or delete asking
      if ($currentAvatar && $file) {
        if (File::exists($currentAvatar->getPath())) {
          unlink($currentAvatar->getPath());
        }
        $currentAvatar->delete();
      }
      // dd($file);
      if ($file) {
        $user->addMedia($file)
          ->usingFileName($file->hashName())
          ->toMediaCollection('avatar image');
        return true;
      }

      return false;
    });

    if ($uploaded) {
      $updated = User::find($user_id);
      return  [ 'has_avatar_image' => $updated->has_avatar_image
              , 'avatar_image_path' => $updated->avatar_image_path
              , 'thumbnail_avatar_path' => $updated->thumbnail_avatar_path
              , 'avatar' => $updated->avatar
              ];
    }

    return false;
  }

  /**
   * Synchronization role to user
   *
   * @param String $username
   * @param String $role_name
   * @return Object|Boolean
   */
  public function sync_role(String $username, String $role_name)
  {
    $user = $this->user->where('username', $username)->first();
    try {
      return $user->assignRole($role_name);
    } catch (\Throwable $th) {
      return false;
    }
  }

  /**
   * Update password user
   *
   * @param String $username
   * @param String $role_name
   * @return Object|Boolean
   */
  public function updatePassword(Request $request)
  {
    $id = auth()->user()->v_userid;
    $user = $this->user->where('v_userid', $id)->first();
    try {
      $user->update([
        'v_userpass' => bcrypt($request->password),
        'd_last_update_pass' => Carbon::now()
      ]);
      return true;
    } catch (\Throwable $th) {
      Log::error($th);
      return false;
    }
  }

  /**
   * Update password user
   *
   * @param String $username
   * @param String $role_name
   * @return Object|Boolean
   */
  public function updatePasswordAdminPdukpd(Request $request)
  {
    $user = $this->user->where('v_userid', $request->user_id)->first();
    try {
      $user->update([
        'v_userpass' => bcrypt($request->password),
        'd_last_update_pass' => Carbon::now()
      ]);
      return true;
    } catch (\Throwable $th) {
      Log::error($th);
      return false;
    }
  }
}
