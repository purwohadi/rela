<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Repositories\Contracts\OpdRepositoryInterface;
use App\Repositories\Contracts\DomainLayananRepositoryInterface;
use App\Repositories\Contracts\DomainProsesRepositoryInterface;
use App\Repositories\Contracts\ArsSpbeRepositoryInterface;

class DomainController extends Controller
{
	protected $arsSpbeRepositoryInterface;
	protected $domainLayananRepositoryInterface;
	protected $opdRepositoryInterface;
	protected $domainProsesRepositoryInterface;

	/**
	 * ProfilController constructor.
	 *
	 * @param ProfilRepositoryInterface $permission
	 */
	public function __construct (OpdRepositoryInterface $opdRepositoryInterface,
								 DomainLayananRepositoryInterface $domainLayananRepositoryInterface,
								 DomainProsesRepositoryInterface $domainProsesRepositoryInterface,
								 ArsSpbeRepositoryInterface $arsSpbeRepositoryInterface) {
		$this->opdRepositoryInterface			= $opdRepositoryInterface;
		$this->domainLayananRepositoryInterface = $domainLayananRepositoryInterface;
		$this->domainProsesRepositoryInterface	= $domainProsesRepositoryInterface;
		$this->arsSpbeRepositoryInterface		= $arsSpbeRepositoryInterface;
	}

	/** Get data perangkat daerah*/
	public function dataPerangkatDaerah(Request $request)
	{
		return $this->opdRepositoryInterface->dataPerangkatDaerah($request);
	}

	
	/** Get data perangkat daerah by slug*/
	public function dataPerangkatDaerahBySlug(Request $request)
	{
		return $this->opdRepositoryInterface->dataPerangkatDaerahBySlug($request);
	}

	 /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function getDomainLayanan(Request $request)
  {
    return $this->domainLayananRepositoryInterface->getDomainLayanan($request);
  }

  public function getDataLayananUnique(Request $request)
  {
    return $this->domainLayananRepositoryInterface->getDataLayananUnique($request);
  }

  /**
	 * Delete Domain Layanan
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainLayanan(Request $request)
	{
		$deleteData		= json_decode($this->domainLayananRepositoryInterface->deleteDataDomainLayanan($request));
		$type 			= $deleteData->type;
		$message 		= $deleteData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type);
	}

	/**
	 * Store update tabel domain_layanan
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainLayanan(Request $request)
	{
		$updateDataDomainLayanan 	= json_decode($this->domainLayananRepositoryInterface->updateDataDomainLayanan($request));
		$type 						= $updateDataDomainLayanan->type;
		$message 					= $updateDataDomainLayanan->message;
		return $this->redirectResponse($request, trans("{$message}"), $type);
	}

	/** Get data proses bisnis*/
	public function dataProsesBisnis(Request $request)
	{
		return $this->domainProsesRepositoryInterface->dataProsesBisnis($request);
	}


	/** Get data ral dari tr_ars_spbe*/
	public function searchRal(Request $request)
	{
		return $this->arsSpbeRepositoryInterface->searchRal($request);
	}

	/** Get data ral dari tr_ars_spbe*/
	public function searchRef(Request $request)
	{
		return $this->arsSpbeRepositoryInterface->searchRef($request);
	}

	/**
	 * Insert data to domain layanan with the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\DomainLayanan  $domainLayanan
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainLayanan(Request $request)
	{
		$saveData 	= json_decode($this->domainLayananRepositoryInterface->simpanDataDomainLayanan($request));
		$type 				= $saveData->type;
		$message 			= $saveData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type, $saveData);
	}

	/** Get data domain layanan*/
	public function dataDomainLayanan(Request $request)
	{
		return $this->domainLayananRepositoryInterface->dataDomainLayanan($request);
	}
	
	/** Get data layanan detail proses*/
	public function getLayananDetail(Request $request)
	{
		return $this->domainLayananRepositoryInterface->getLayananDetail($request);
	}
	
	/** Get data layanan detail proses byId*/
	public function getLayananDetailById(Request $request)
	{
		return $this->domainLayananRepositoryInterface->getLayananDetailById($request);
	}
	
	/**
	 * Insert data to domain layanan detail with the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\DomainLayananDetail  $domainLayananDetail
	 * @return \Illuminate\Http\Response
	 */
	public function simpanLayananDetail(Request $request)
	{
		$saveData 	= json_decode($this->domainLayananRepositoryInterface->simpanLayananDetail($request));
		$type 				= $saveData->type;
		$message 			= $saveData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type, $saveData);
	}

	/**
	 * Updat data to domain layanan detail with the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\DomainLayananDetail  $domainLayananDetail
	 * @return \Illuminate\Http\Response
	 */
	public function ubahLayananDetail(Request $request)
	{
		$saveData 	= json_decode($this->domainLayananRepositoryInterface->ubahLayananDetail($request));
		$type 				= $saveData->type;
		$message 			= $saveData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type, $saveData);
	}
	
  	/**
	 * Delete Domain Layanan detail
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainLayananDetail(Request $request)
	{
		$deleteData		= json_decode($this->domainLayananRepositoryInterface->deleteDataDomainLayananDetail($request));
		$type 			= $deleteData->type;
		$message 		= $deleteData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type);
	}

	/**
	 * Get data view jabatan tropd eselon 3
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function getJabatanTropdEselon3(Request $request)
	{
		return $this->domainLayananRepositoryInterface->getJabatanTropdEselon3($request);
	}
	
	/**
	 * Get data view jabatan tropd eselon 4
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function getJabatanTropdEselon4(Request $request)
	{
		return $this->domainLayananRepositoryInterface->getJabatanTropdEselon4($request);
	}
}
