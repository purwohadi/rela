<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Repositories\Contracts\DomainEdukasiKeamananRepositoryInterface;

class EdukasiKeamananController extends Controller
{
	protected $domainEdukasiKeamananRepositoryInterface;

	/**
	 * EdukasiKeamananController constructor.
	 *
	 * @param DomainEdukasiKeamananRepositoryInterface $permission
	 */
	public function __construct (DomainEdukasiKeamananRepositoryInterface $domainEdukasiKeamananRepositoryInterface) {
		$this->domainEdukasiKeamananRepositoryInterface			= $domainEdukasiKeamananRepositoryInterface;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function dataEdukasiKeamanan(Request $request)
	{
		return $this->domainEdukasiKeamananRepositoryInterface->dataEdukasiKeamanan($request);
	}
	
	/**
	 * Insert data to domain_edukasi_keamanan with the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Repositories\Contracts\DomainEdukasiKeamananRepositoryInterface  $domainEdukasiKeamananRepositoryInterface
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainEdukasiKeamanan(Request $request)
	{
		$saveData			= json_decode($this->domainEdukasiKeamananRepositoryInterface->simpanDataDomainEdukasiKeamanan($request));
		$type 				= $saveData->type;
		$message 			= $saveData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type, $saveData);
	}

	/**
	 * Store update tabel domain_edukasi_keamanan
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainEdukasiKeamanan(Request $request)
	{
		$updateData					= json_decode($this->domainEdukasiKeamananRepositoryInterface->updateDataDomainEdukasiKeamanan($request));
		$type 						= $updateData->type;
		$message 					= $updateData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type);
	}

	/**
	 * Delete Domain edukasi keamanan
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainEdukasiKeamanan(Request $request)
	{
		$deleteData		= json_decode($this->domainEdukasiKeamananRepositoryInterface->deleteDataDomainEdukasiKeamanan($request));
		$type 			= $deleteData->type;
		$message 		= $deleteData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type);
	}
	
	/** Get data domain edukasi keamanan*/
	public function searchEdukasiKeamanan(Request $request)
	{
		return $this->domainEdukasiKeamananRepositoryInterface->searchEdukasiKeamanan($request);
	}

}
