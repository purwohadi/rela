<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface DomainInfraJipRepositoryInterface
{
	/**
	 * Get's domain infra jip by specific condition.
	 *
	 * @return mixed
	 */
	public function dataIntraPemerintah(Request $request);

	/**
	 * Save Data Domain Infra Jip
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainInfraJip(Request $request);

	/**
	 * Save Update Data Infra Jip
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainInfraJip(Request $request);

	/**
	 * Delete data domain Infra Jip
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainInfraJip(Request $request);

	/**
	 * Get's domain layanan.
	 *
	 * @return mixed
	 */
	public function searchIntraPemerintah(Request $request);


	/**
	 * Get's domain infra jip by specific condition.
	 *
	 * @return mixed
	 */
	public function getDataBy(Request $request);

	/**
	 * Get's a perangkat daerah
	 *
	 * @param int
	 */
	public function dataPerangkatDaerah(Request $request);

	/**
	 * Get's a perangkat daerah  nama pemilik
	 *
	 * @param int
	 */
	public function dataPerangkatDaerahPemilik(Request $request);

	/**
	 * Get's domain infra fasilitas by specific condition.
	 *
	 * @return mixed
	 */
	public function getDomainCode(Request $request);
}
