<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface DomainPeningkatanKeamananRepositoryInterface
{
	/**
	 * Get's domain Peningkatan keamanan by specific condition.
	 *
	 * @return mixed
	 */
	public function dataPeningkatanKeamanan(Request $request);

	/**
	 * Save Data Domain Peningkatan Keamanan
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainPeningkatanKeamanan(Request $request);
	
	/**
	 * Save Update Data Peningkatan Keamanan
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainPeningkatanKeamanan(Request $request);

	/**
	 * Delete data domain Peningkatan Keamanan
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainPeningkatanKeamanan(Request $request);
		
	/**
	 * Get's domain layanan.
	 *
	 * @return mixed
	 */
	public function searchDomainPeningkatanKeamanan(Request $request);

	/**
   	* Get's metadata.
   	*
   	* @return mixed
   	*/
	public function getMetadataApp(Request $request);

	/**
   	* Get's metadata.
   	*
   	* @return mixed
   	*/
	public function getMetadataNetdev(Request $request);
}
