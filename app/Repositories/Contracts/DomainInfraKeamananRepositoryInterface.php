<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface DomainInfraKeamananRepositoryInterface
{
	/**
	 * Get's domain infra keamanan by specific condition.
	 *
	 * @return mixed
	 */
	public function dataInfraKeamanan(Request $request);

	/**
	 * Save Data Domain Infra Keamanan
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainInfraKeamanan(Request $request);
	
	/**
	 * Save Update Data Infra Keamanan
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainInfraKeamanan(Request $request);

	/**
	 * Delete data domain Infra Keamanan
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainInfraKeamanan(Request $request);
		
	/**
	 * Get's domain layanan.
	 *
	 * @return mixed
	 */
	public function searchInfraKeamanan(Request $request);

	/**
	 * Get metadata terkait.
	 *
	 * @return mixed
	 */
	public function getMetadata(Request $request);
}
