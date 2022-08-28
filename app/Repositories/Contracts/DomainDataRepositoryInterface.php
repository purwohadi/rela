<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface DomainDataRepositoryInterface
{

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
  public function get_data_radl1(Request $request);

  /**
   * Get's groups by specific condition.
   *
   * @return mixed
   */
  public function get_data_radl2(Request $request);

  public function get_data_radl3(Request $request);

  /**
   * Get's probis by specific condition.
   *
   * @return mixed
   */
  public function get_data_probis_terkait(Request $request);

  /**
   * Save a data informasi
   *
   * @param Illuminate\Http\Request $request
   */
  public function save(Request $request);

  /**
   * Get's domain probis.
   *
   * @return mixed
   */
  public function dataInformasi($info_id, Request $request);

  /**
   * Get's urusan by specific condition.
   *
   * @return mixed
   */
  public function get_detail_data(Request $request);

  /**
   * Updates a data info.
   *
   * @param int
   * @param array
   */
  public function update(Request $request, $info_id);

  /**
   * Save a data informasi
   *
   * @param Illuminate\Http\Request $request
   */
  public function save_detail(Request $request);

  /**
   * Get's urusan by specific condition.
   *
   * @return mixed
   */
  public function get_detail_data_informasi($id, Request $request);

  /**
   * Get's urusan by specific condition.
   *
   * @return mixed
   */
  public function get_probis_data_detail($id, Request $request);

  /**
   * Updates a detail data info.
   *
   * @param int
   * @param array
   */
  public function update_detail(Request $request, $id);

  /**
   * Deletes a detail data.
   *
   *  @return \Illuminate\Http\Response
   */
  public function delete_detail(Request $request);

  /**
   * Deletes a detail data.
   *
   *  @return \Illuminate\Http\Response
   */
  public function delete(Request $request);

  public function getDataUnique(Request $request);
}
