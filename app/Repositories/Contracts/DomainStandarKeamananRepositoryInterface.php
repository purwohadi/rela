<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface DomainStandarKeamananRepositoryInterface
{
	/**
	 * Get's domain standar keamanan by specific condition.
	 *
	 * @return mixed
	 */
	public function dataStandarTeknisKeamanan(Request $request);

	/**
	 * Save Data Domain standar keamanan
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainStandarKeamanan(Request $request);
	
	/**
	 * Save Update Data standar keamanan
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainStandarKeamanan(Request $request);

	/**
	 * Delete data domain standar keamanan
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainStandarKeamanan(Request $request);
		
	/**
	 * Get's domain standar keamanan.
	 *
	 * @return mixed
	 */
	public function searchStandarKeamanan(Request $request);

	/**
   	* Get's metadata.
   	*
   	* @return mixed
   	*/
	public function getMetadata(Request $request);

	/**
   	* Get's metadata.
   	*
   	* @return mixed
   	*/
	public function searchNamaAplikasi(Request $request);
}
