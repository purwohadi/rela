<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface DomainInfrastrukturCloudRepositoryInterface
{
  /**
   * Get's groups by specific condition.
   *
   * @return mixed
   */
  public function search(Request $request);

  /**
   * Get's rail by specific condition.
   *
   * @return mixed
   */
  public function get_data_rail(Request $request, $level = 1);

  /**
   * Get's rail by specific condition.
   *
   * @return mixed
   */
  public function get_data_rail1(Request $request);

  /**
   * Get's rail by specific condition.
   *
   * @return mixed
   */
  public function get_data_rail2(Request $request);

  /**
   * Get's rail by specific condition.
   *
   * @return mixed
   */
  public function get_data_rail3(Request $request, $rail3);

  /**
   * Get's groups by specific condition.
   *
   * @return mixed
   */
  public function get_data_metadata(Request $request);


  /**
   * Get's groups by specific condition.
   *
   * @return mixed
   */
  public function get_list_instansi(Request $request);

  /**
   * Get's groups by specific condition.
   *
   * @return mixed
   */
  public function get_list_tipe(Request $request);

  /**
   * Get's groups by specific condition.
   *
   * @return mixed
   */
  public function get_list_owner(Request $request);

  /**
   * Save a cloud
   *
   * @param Illuminate\Http\Request $request
   */
  public function save(Request $request);

  /**
   * Get's domain infra cloud.
   *
   * @return mixed
   */
  public function dataInfrastrukturCloud($id, Request $request);

  /**
   * Deletes a domain cloud.
   *
   *  @return \Illuminate\Http\Response
   */
  public function delete(Request $request);

  /**
   * Updates a cloud.
   *
   * @param int
   * @param array
   */
  public function update(Request $request, $id);


  /**
   * Get's domain infra storage.
   *
   * @return mixed
   */
  public function get_metadata_detail_data(Request $request, $id);

  /**
   * Get's a perangkat daerah
   *
   * @param int
   */
  public function dataPerangkatDaerah(Request $request);

}
