<?php

namespace App\Repositories;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Repositories\Contracts\PermissionRepositoryInterface;

class PermissionRepository implements PermissionRepositoryInterface
{
  protected $permission;

  public function __construct(Permission $permission)
  {
    $this->permission = $permission;
  }

  /**
   * Get's all permission.
   *
   * @return mixed
   */
  public function all()
  {
    return $this->permission->all();
  }

  /**
   * Get's a permission by it's ID
   *
   * @param int
   */
  public function get($permission)
  {
    return $this->permission->find($permission);
  }

  /**
   * Get's a permission by it's name
   *
   * @param String $name
   * @param String $guard_name
   */
  public function findByName($name, $guard_name = null)
  {
    try {
      $permission = $this->permission->findByName($name, $guard_name);
      return $permission;
    } catch (\Exception $e) {
      return false;
    }
  }

  /**
   * Get's permissions by specific condition.
   *
   * @return mixed
   */
  public function search(Request $request)
  {
    return $request->has('limit')
      ? $this->permission->getPagingData()
      : $this->permission->getAllData();
  }

  /**
   * Save a permission
   *
   * @param array $input
   */
  public function save(array $input)
  {
    return $this->permission->findOrCreate($input['name'], $input['guard_name']);
  }

  /**
   * Updates a permission.
   *
   * @param int
   * @param array
   */
  public function update($permission_id, array $permission_data)
  {
    $permission = $this->permission->find($permission_id);
    return $permission->update($permission_data);
  }

  /**
   * Deletes a permission.
   *
   * @param int
   */
  public function delete($permission_id)
  {
    $permission = $this->get($permission_id);
    $role = $permission->roles()->count();
    $menu = $permission->menu()->count();
    if ($role || $menu) return false;
    return $permission->delete();
  }
}
