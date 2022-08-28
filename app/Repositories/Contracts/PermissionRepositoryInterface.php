<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface PermissionRepositoryInterface
{
  /**
   * Get's all permission.
   *
   * @return mixed
   */
  public function all();

  /**
   * Get's a permission by it's ID
   *
   * @param int
   */
  public function get($permission_id);

  /**
   * Get's permissions by specific condition.
   *
   * @return mixed
   */
  public function search(Request $request);

  /**
   * Save a permission
   *
   * @param array $input
   */
  public function save(array $input);

  /**
   * Updates a permission.
   *
   * @param int
   * @param array
   */
  public function update($permission_id, array $permission_data);

  /**
   * Deletes a permission.
   *
   * @param int
   */
  public function delete($permission_id);
}
