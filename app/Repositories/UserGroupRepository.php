<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\UserGroup;
use App\Http\Resources\UserGroupResources;
use App\Repositories\Contracts\UserGroupRepositoryInterface;

class UserGroupRepository implements UserGroupRepositoryInterface
{
  protected $userGroup;

  public function __construct(UserGroup $userGroup)
  {
    $this->userGroup = $userGroup;
  }

  /**
   * Get's all userGroup.
   *
   * @return mixed
   */
  public function all()
  {
    return $this->userGroup->all();
  }

  /**
   * Get's a userGroup by it's ID
   *
   * @param int
   */
  public function getByUserId($user_id)
  {
    return $this->userGroup->find($user_id);
  }

  /**
   * Get's a userGroup by it's name
   *
   * @param String $name
   * @param String $guard_name
   */
  public function findByName($name, $guard_name = null)
  {
    try {
      $userGroup = $this->userGroup->findByName($name, $guard_name);
      return $userGroup;
    } catch (\Exception $e) {
      return false;
    }
  }

  /**
   * Get's userGroup by specific condition.
   *
   * @return mixed
   */
  // public function search(Request $request)
  // {
  //   $results = $request->has('limit')
  //     ? $this->userGroup->getPagingData()
  //     : $this->userGroup->getAllData();

  //     return UserGroupResources::collection($results);
  // }

  /**
   * Save a userGroup
   *
   * @param array $input
   */
  public function save(array $input)
  {
    return $this->userGroup->findOrCreate($input['name'], $input['guard_name']);
  }

  /**
   * Updates a userGroup.
   *
   * @param int
   * @param array
   */
  public function update($userGroup_id, array $userGroup_data)
  {
    $userGroup = $this->userGroup->find($userGroup_id);
    return $userGroup->update($userGroup_data);
  }

  /**
   * Deletes a userGroup.
   *
   * @param int
   */
  public function delete($userGroup_id)
  {
    $userGroup = $this->get($userGroup_id);
    $user = $userGroup->users()->count();
    if ($user) return false;
    return $userGroup->delete();
  }

  public function syncPermissions($userGroup_name, Array $permissions)
  {
    try {
      $userGroup = $this->findByName($userGroup_name);
      return $userGroup->syncPermissions($permissions);
    } catch (\Exception $ex) {
      return false;
    }
  }
}
