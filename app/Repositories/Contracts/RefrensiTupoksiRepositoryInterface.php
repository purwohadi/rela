<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface RefrensiTupoksiRepositoryInterface
{
  /**
   * Get's all group.
   *
   * @return mixed
   */
  public function all();

  /**
   * Get's a group by it's ID
   *
   * @param int
   */
  public function all_by_status($status);

  /**
   * Get's a group by it's ID
   *
   * @param int
   */
  public function get($group_id);

  /**
   * Get's groups by specific condition.
   *
   * @return mixed
   */
  public function search(Request $request);

  /**
   * Get's groups by specific condition.
   *
   * @return mixed
   */
  public function get_option(Request $request);

  /**
   * Save a group
   *
   * @param array $input
   */
  public function save(array $input);

  /**
   * Updates a group.
   *
   * @param int
   * @param array
   */
  public function update($group_id, array $group_data);
}
