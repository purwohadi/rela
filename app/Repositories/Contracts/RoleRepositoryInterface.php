<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface RoleRepositoryInterface
{
  /**
   * Get's all role.
   *
   * @return mixed
   */
  public function all();

  /**
   * Get's a role by it's ID
   *
   * @param int
   */
  public function get($role_id);

  /**
   * Get's roles by specific condition.
   *
   * @return mixed
   */
  public function search(Request $request);

  /**
   * Save a role
   *
   * @param array $input
   */
  public function save(array $input);

  /**
   * Updates a role.
   *
   * @param int
   * @param array
   */
  public function update($role_id, array $role_data);

  /**
   * Deletes a role.
   *
   * @param int
   */
  public function delete($role_id);

  /**
   * Sync all permission from role
   *
   * @param string $role_name
   * @param array $permissions
   * @return mixed
   */
  public function syncPermissions($role_name, array $permissions);
}
