<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface DomainProsesBisnisRepositoryInterface
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
  public function get_data_rabl(Request $request, $level = 1);

  /**
   * Get's groups by specific condition.
   *
   * @return mixed
   */
  public function get_data_rabl_2(Request $request);

  /**
   * Get's groups by specific condition.
   *
   * @return mixed
   */
  public function get_data_rabl_3(Request $request);

  /**
   * Get's groups by specific condition.
   *
   * @return mixed
   */
  public function get_data_program(Request $request);

  /**
   * Get's groups by specific condition.
   *
   * @return mixed
   */
  public function get_data_rabl_4(Request $request);

  /**
   * Save a group
   *
   * @param Illuminate\Http\Request $request
   */
  public function save(Request $request);

  /**
   * Updates a group.
   *
   * @param int
   * @param array
   */
  public function update(Request $request, $proses_id);

  /**
   * Deletes a domain proses.
   *
   *  @return \Illuminate\Http\Response
   */
  public function delete(Request $request);

  /**
   * Get's domain probis.
   *
   * @return mixed
   */
  public function dataProsesBisnis($proses_id, Request $request);

  /**
   * Get's urusan by specific condition.
   *
   * @return mixed
   */
  public function get_urusan(Request $request);
}
