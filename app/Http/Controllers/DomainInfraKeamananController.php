<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\DomainInfraKeamananRepositoryInterface;

class DomainInfraKeamananController extends Controller
{
    	/**
	 * JaringanInfraKeamananController constructor.
	 *
	 * @param DomainInfraKeamananRepositoryInterface $permission
	 */
	public function __construct (DomainInfraKeamananRepositoryInterface $domainInfraKeamananRepositoryInterface) {
		$this->domainInfraKeamananRepositoryInterface			= $domainInfraKeamananRepositoryInterface;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function dataInfraKeamanan(Request $request)
	{
		return $this->domainInfraKeamananRepositoryInterface->dataInfraKeamanan($request);
	}


	/**
	 * Insert data to domain_infra_keamanan with the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Repositories\Contracts\DomainInfraKeamananRepositoryInterface  $DomainInfraKeamananRepositoryInterface
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainInfraKeamanan(Request $request)
	{
		$saveData			= json_decode($this->domainInfraKeamananRepositoryInterface->simpanDataDomainInfraKeamanan($request));
		$type 				= $saveData->type;
		$message 			= $saveData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type, $saveData);
	}

	/**
	 * Store update tabel domain_layanan
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainInfraKeamanan(Request $request)
	{
		$updateData					= json_decode($this->domainInfraKeamananRepositoryInterface->updateDataDomainInfraKeamanan($request));
		$type 						= $updateData->type;
		$message 					= $updateData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type);
	}

	/**
	 * Delete Domain Layanan
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainInfraKeamanan(Request $request)
	{
		$deleteData		= json_decode($this->domainInfraKeamananRepositoryInterface->deleteDataDomainInfraKeamanan($request));
		$type 			= $deleteData->type;
		$message 		= $deleteData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type);
	}

	/** Get data domain infra keamanan*/
	public function searchInfraKeamanan (Request $request)
	{
		return $this->domainInfraKeamananRepositoryInterface->searchInfraKeamanan($request);
		//dd($request->all());
	}

	public function getMetadata(Request $request)
	{
		return $this->domainInfraKeamananRepositoryInterface->getMetadata($request);
	}
}
