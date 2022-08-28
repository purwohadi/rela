<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface DomainAuditKeamananRepositoryInterface
{
	/**
	 * Get's domain audit keamanan by specific condition.
	 *
	 * @return mixed
	 */
	public function dataAuditKeamanan(Request $request);

	/**
	 * Save Data Domain Audit Keamanan
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainAuditKeamanan(Request $request);
	
	/**
	 * Save Update Data Audit Keamanan
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainAuditKeamanan(Request $request);

	/**
	 * Delete data domain Audit Keamanan
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainAuditKeamanan(Request $request);
		
	/**
	 * Get's domain audit.
	 *
	 * @return mixed
	 */
	public function searchDomainAuditKeamanan(Request $request);

	/**
   	* Get's metadata.
   	*
   	* @return mixed
   	*/
	public function getMetadata(Request $request);
}
