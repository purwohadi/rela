<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Repositories\Contracts\DomainStandarKeamananRepositoryInterface;

class StandarTeknisKeamananController extends Controller
{
	protected $domainStandarKeamananRepositoryInterface;

	/**
	 * StandarTeknisKeamananController constructor.
	 *
	 * @param DomainStandarKeamananRepositoryInterface $permission
	 */
	public function __construct (DomainStandarKeamananRepositoryInterface $domainStandarKeamananRepositoryInterface) {
		$this->domainStandarKeamananRepositoryInterface			= $domainStandarKeamananRepositoryInterface;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function dataStandarKeamanan(Request $request)
	{
		return $this->domainStandarKeamananRepositoryInterface->dataStandarTeknisKeamanan($request);
	}
	
	/**
	 * Insert data to domain_standar_keamanan with the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Repositories\Contracts\DomainStandarKeamananRepositoryInterface  $domainStandarKeamananRepositoryInterface
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainStandarKeamanan(Request $request)
	{
		$saveData			= json_decode($this->domainStandarKeamananRepositoryInterface->simpanDataDomainStandarKeamanan($request));
		$type 				= $saveData->type;
		$message 			= $saveData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type, $saveData);
	}

	/**
	 * Store update tabel domain_standar-keamanan
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainStandarKeamanan(Request $request)
	{
		$updateData					= json_decode($this->domainStandarKeamananRepositoryInterface->updateDataDomainStandarKeamanan($request));
		$type 						= $updateData->type;
		$message 					= $updateData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type);
	}

	/**
	 * Delete Domain standar keamanan
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainStandarKeamanan(Request $request)
	{
		$deleteData		= json_decode($this->domainStandarKeamananRepositoryInterface->deleteDataDomainStandarKeamanan($request));
		$type 			= $deleteData->type;
		$message 		= $deleteData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type);
	}
	
	/** Get data domain standar keamanan*/
	public function searchStandarKeamanan(Request $request)
	{
		return $this->domainStandarKeamananRepositoryInterface->searchStandarKeamanan($request);
	}

	/** Get metadata terkait*/
	public function getMetadata(Request $request)
	{
		return $this->domainStandarKeamananRepositoryInterface->getMetadata($request);
	}

	/** Search nama aplikasi*/
	public function searchNamaAplikasi(Request $request)
	{
		return $this->domainStandarKeamananRepositoryInterface->searchNamaAplikasi($request);
	}
}
