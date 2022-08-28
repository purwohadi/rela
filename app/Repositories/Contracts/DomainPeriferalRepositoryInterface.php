<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface DomainPeriferalRepositoryInterface
{
	/**
	 * Get's domain infra pheri by specific condition.
	 *
	 * @return mixed
	 */
	public function dataIntraPheri(Request $request);

	/**
	 * Save Data Domain Infra Pheri
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainInfraPheri(Request $request);
	
	/**
	 * Save Update Data Infra Pheri
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainInfraPheri(Request $request);

	/**
	 * Delete data domain Infra Pheri
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainInfraPheri(Request $request);
		
	/**
	 * Get's domain infra pheri.
	 *
	 * @return mixed
	 */
	public function searchIntraPheri(Request $request);
	
	/**
	 * Get's a perangkat daerah 
	 *
	 * @param int
	 */
	public function dataPerangkatDaerah(Request $request);
}
