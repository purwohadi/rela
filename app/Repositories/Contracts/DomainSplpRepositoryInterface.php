<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface DomainSplpRepositoryInterface
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
  public function get_data_rail3(Request $request);

  /**
   * Get's rail by specific condition.
   *
   * @return mixed
   */
  public function get_data_rail4(Request $request);


  /**
   * Get's app by specific condition.
   *
   * @return mixed
   */
  public function get_list_app(Request $request);

  /**
   * Get's app by specific condition.
   *
   * @return mixed
   */
  public function get_list_app_connected(Request $request);

  /**
   * Get's jenis.
   *
   * @return mixed
   */
  public function get_list_jenis(Request $request);

  /**
   * Get's jip by specific condition.
   *
   * @return mixed
   */
  public function get_list_jip(Request $request);

  /**
   * Save a splp
   *
   * @param Illuminate\Http\Request $request
   */
  public function save(Request $request);

  /**
   * Get's domain infra splp.
   *
   * @return mixed
   */
  public function dataInfrastrukturSplp($id, Request $request);

  /**
   * Deletes a infra splp.
   *
   *  @return \Illuminate\Http\Response
   */
  public function delete(Request $request);

  /**
   * Updates a splp.
   *
   * @param int
   * @param array
   */
  public function update(Request $request, $id);

  /**
   * Get's jenis.
   *
   * @return mixed
   */
  public function get_data_instansi(Request $request);

  /**
   * Get's jenis.
   *
   * @return mixed
   */
  public function get_data_metadata(Request $request);

  /**
   * Get's metadata jip.
   *
   * @return mixed
   */
  public function get_metadata_detail_data(Request $request, $id);

}
