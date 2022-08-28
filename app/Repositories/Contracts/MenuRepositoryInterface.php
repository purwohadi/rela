<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface MenuRepositoryInterface
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
   * Get's only menu parents
   *
   * @param int
   */
  public function getParents();

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
   * Updates a menu.
   *
   * @param int
   * @param array
   */
  public function update($menu_id, array $menu_data);

  /**
   * Deletes a permission.
   *
   * @param int
   */
  public function delete($permission_id);

  /**
   * Get User Structure Menu
   *
   * @param Array $permission_id
   * @return Array|Collecion
   */
  public function getStructureMenu(array $permission_id);
}
