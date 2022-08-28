<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface RefrensiKemendagriRepositoryInterface
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

  public function getRefProgram(Request $request);
  public function getRefKegiatan(Request $request);
  public function getRefSubKegiatan(Request $request);


}
