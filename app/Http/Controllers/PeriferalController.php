<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Repositories\Contracts\DomainPeriferalRepositoryInterface;

class PeriferalController extends Controller
{
	protected $domainPeriferalRepositoryInterface;

	/**
	 * PeriferalController constructor.
	 *
	 * @param DomainPeriferalRepositoryInterface $permission
	 */
	public function __construct (DomainPeriferalRepositoryInterface $domainPeriferalRepositoryInterface) {
		$this->domainPeriferalRepositoryInterface			= $domainPeriferalRepositoryInterface;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function dataIntraPheri(Request $request)
	{
		return $this->domainPeriferalRepositoryInterface->dataIntraPheri($request);
	}
	
	/**
	 * Insert data to domain_infra_pheri with the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Repositories\Contracts\DomainPeriferalRepositoryInterface  $domainPeriferalRepositoryInterface
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainInfraPheri(Request $request)
	{
		$saveData			= json_decode($this->domainPeriferalRepositoryInterface->simpanDataDomainInfraPheri($request));
		$type 				= $saveData->type;
		$message 			= $saveData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type, $saveData);
	}

	/**
	 * Store update tabel domain_infra_pheri
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainInfraPheri(Request $request)
	{
		$updateData					= json_decode($this->domainPeriferalRepositoryInterface->updateDataDomainInfraPheri($request));
		$type 						= $updateData->type;
		$message 					= $updateData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type);
	}

	/**
	 * Delete Domain infra pheri
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainInfraPheri(Request $request)
	{
		$deleteData		= json_decode($this->domainPeriferalRepositoryInterface->deleteDataDomainInfraPheri($request));
		$type 			= $deleteData->type;
		$message 		= $deleteData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type);
	}
	
	/** Get data domain infra Pheri*/
	public function searchIntraPheri (Request $request)
	{
		return $this->domainPeriferalRepositoryInterface->searchIntraPheri($request);
	}

	/** Get data perangkat daerah*/
	public function dataPerangkatDaerah(Request $request)
	{
		return $this->domainPeriferalRepositoryInterface->dataPerangkatDaerah($request);
	}

}
