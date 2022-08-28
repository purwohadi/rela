<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface DomainEdukasiKeamananRepositoryInterface
{
	/**
	 * Get's domain edukasi keamanan by specific condition.
	 *
	 * @return mixed
	 */
	public function dataEdukasiKeamanan(Request $request);

	/**
	 * Save Data Domain Edukasi Keamanan
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainEdukasiKeamanan(Request $request);
	
	/**
	 * Save Update Data Edukasi Keamanan
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainEdukasiKeamanan(Request $request);

	/**
	 * Delete data domain Edukasi Keamanan
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainEdukasiKeamanan(Request $request);
		
	/**
	 * Get's domain layanan.
	 *
	 * @return mixed
	 */
	public function searchDomainEdukasiKeamanan(Request $request);

	/**
   	* Get's metadata.
   	*
   	* @return mixed
   	*/
	public function getMetadata(Request $request);
}
