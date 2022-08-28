<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface DomainInfraStorageRepositoryInterface
{
	/**
	 * Get's domain infra storage by specific condition.
	 *
	 * @return mixed
	 */
	public function dataIntraStorage(Request $request);

	/**
	 * Save Data Domain Infra storage
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainInfraStorage(Request $request);

	/**
	 * Save Update Data Infra storage
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainInfraStorage(Request $request);

	/**
	 * Delete data domain Infra storage
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainInfraStorage(Request $request);

	/**
	 * Get's domain infra storage.
	 *
	 * @return mixed
	 */
	public function searchIntraStorage(Request $request);

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
   * Get's domain infra storage.
   *
   * @return mixed
   */
  public function getMetadataKeamanan(Request $request);

  /**
   * Get's domain infra storage.
   *
   * @return mixed
   */
  public function getMetadataSplp(Request $request);

    /**
     * Get's rail by specific condition.
     *
     * @return mixed
     */
    public function get_instansi(Request $request);
}
