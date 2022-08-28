<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface DomainLayananRepositoryInterface
{
	/**
	 * Get's domain layanan by specific condition.
	 *
	 * @return mixed
	 */
	public function getDomainLayanan(Request $request);
  
	/**
	 * Delete data domain layanan
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainLayanan(Request $request);
  
  	/**
	 * Save Update Data domain layanan.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainLayanan(Request $request);

	/**
	 * Save Data Domain Layanan
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainLayanan(Request $request);

	 /**
	 * Get's domain layanan.
	 *
	 * @return mixed
	 */
	public function dataDomainLayanan(Request $request);
	
	 /**
	 * Get's layanan detail proses.
	 *
	 * @return mixed
	 */
	public function getLayananDetail(Request $request);
	
	 /**
	 * Get's layanan detail by id.
	 *
	 * @return mixed
	 */
	public function getLayananDetailById(Request $request);
	
	/**
	 * Save Data Domain Layanan Detail
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function simpanLayananDetail(Request $request);
		
	/**
	 * update Data Domain Layanan Detail
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function ubahLayananDetail(Request $request);

	/**
	 * Delete data domain layanan detail
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainLayananDetail(Request $request);

	/**
	 * Get's domain layanan unique.
	 *
	 * @return mixed
	 */
	public function getDataLayananUnique(Request $request);
	
	/**
	 * Get's data view jabatan tropd eselon 3.
	 *
	 * @return mixed
	 */
	public function getJabatanTropdEselon3(Request $request);
	
	/**
	 * Get's data view jabatan tropd eselon 4.
	 *
	 * @return mixed
	 */
	public function getJabatanTropdEselon4(Request $request);
}
