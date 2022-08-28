<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface DomainFasilitasRepositoryInterface
{
	/**
	 * Get's domain infra fasilitas by specific condition.
	 *
	 * @return mixed
	 */
	public function getDomainCode(Request $request);

	/**
	 * Get's domain infra fasilitas by specific condition.
	 *
	 * @return mixed
	 */
	public function dataIntraFasilitas(Request $request);

	/**
	 * Save Data Domain Infra fasilitas
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainInfraFasilitas(Request $request);
	
	/**
	 * Save Update Data Infra fasilitas
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainInfraFasilitas(Request $request);

	/**
	 * Delete data domain Infra fasilitas
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainInfraFasilitas(Request $request);
		
	/**
	 * Get's domain infra fasilitas.
	 *
	 * @return mixed
	 */
	public function searchIntraFasilitas(Request $request);

	/**
	 * Get's domain infra fasilitas by specific condition.
	 *
	 * @return mixed
	 */
    public function getDataBy(Request $request);
	
	/**
	 * Get's a perangkat daerah instansi lain
	 *
	 * @param int
	 */
	public function dataPerangkatDaerahInstansiLain(Request $request);
}
