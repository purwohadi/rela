<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Repositories\Contracts\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
  protected $role;

  public function __construct(Role $role)
  {
    $this->role = $role;
  }

  /**
   * Get's all role.
   *
   * @return mixed
   */
  public function all()
  {
    return $this->role->all();
  }

  /**
   * Get's a role by it's ID
   *
   * @param int
   */
  public function get($role_id)
  {
    return $this->role->find($role_id);
  }

  /**
   * Get's a role by it's name
   *
   * @param String $name
   * @param String $guard_name
   */
  public function findByName($name, $guard_name = null)
  {
    try {
      $role = $this->role->findByName($name, $guard_name);
      return $role;
    } catch (\Exception $e) {
      return false;
    }
  }

  /**
   * Get's roles by specific condition.
   *
   * @return mixed
   */
  public function search(Request $request)
  {
    $query = $this->role->with('permissions');
    return $request->has('limit')
      ? $this->role->getPagingData($query)
      : $this->role->getAllData($query);
  }

  /**
   * Save a role
   *
   * @param array $input
   */
  public function save(array $input)
  {
    return $this->role->findOrCreate($input['name'], $input['guard_name']);
  }

  /**
   * Updates a role.
   *
   * @param int
   * @param array
   */
  public function update($role_id, array $role_data)
  {
    $role = $this->role->find($role_id);
    return $role->update($role_data);
  }

  /**
   * Deletes a role.
   *
   * @param int
   */
  public function delete($role_id)
  {
    $role = $this->get($role_id);
    $user = $role->users()->count();
    if ($user) return false;
    return $role->delete();
  }

  public function syncPermissions($role_name, Array $permissions)
  {
    try {
      $role = $this->findByName($role_name);
      return $role->syncPermissions($permissions);
    } catch (\Exception $ex) {
      return false;
    }
  }
}
