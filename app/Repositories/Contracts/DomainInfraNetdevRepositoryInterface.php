<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface DomainInfraNetdevRepositoryInterface
{
	/**
	 * Get's domain infra netdev by specific condition.
	 *
	 * @return mixed
	 */
	public function dataIntraNetdev(Request $request);

	/**
	 * Save Data Domain Infra netdev
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainInfraNetdev(Request $request);

	/**
	 * Save Update Data Infra netdev
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainInfraNetdev(Request $request);

	/**
	 * Delete data domain Infra netdev
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainInfraNetdev(Request $request);

	/**
	 * Get's domain infra netdev.
	 *
	 * @return mixed
	 */
	public function searchIntraNetdev(Request $request);

	/**
	 * Get's domain infra netdev.
	 *
	 * @return mixed
	 */
	public function get_data_rail1(Request $request);

	/**
	 * Get's domain infra netdev.
	 *
	 * @return mixed
	 */
	public function get_data_rail2(Request $request);

	/**
	 * Get's domain infra netdev.
	 *
	 * @return mixed
	 */
	public function get_data_rail3(Request $request);

	/**
	 * Get's domain infra netdev.
	 *
	 * @return mixed
	 */
	public function get_data_rail4(Request $request);

	/**
	 * Get's instansi1.
	 *
	 * @return mixed
	 */
	public function get_data_instansi1(Request $request);

	/**
	 * Get's instansi1.
	 *
	 * @return mixed
	 */
	public function get_data_instansi2(Request $request);

  /**
   * Get's metadata jip.
   *
   * @return mixed
   */
  public function get_metadata_jip_data(Request $request, $id);

  /**
   * Get's metadata jip.
   *
   * @return mixed
   */
  public function get_metadata_fasilitas_data(Request $request, $id);

  /**
   * Get's metadata jip.
   *
   * @return mixed
   */
  public function get_data_opd(Request $request);
}
