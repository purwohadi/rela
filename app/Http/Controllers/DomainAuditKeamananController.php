<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\DomainAuditKeamananRepositoryInterface;

class DomainAuditKeamananController extends Controller
{
    	/**
	 * DomainAuditKeamananController constructor.
	 *
	 * @param DomainAuditKeamananRepositoryInterface $permission
	 */
	public function __construct (DomainAuditKeamananRepositoryInterface $domainAuditKeamananRepositoryInterface) {
		$this->domainAuditKeamananRepositoryInterface			= $domainAuditKeamananRepositoryInterface;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function dataAuditKeamanan(Request $request)
	{
		return $this->domainAuditKeamananRepositoryInterface->dataAuditKeamanan($request);
        //return 'dd($request->all())';
        //return 'ini controller audit keamanan';
	}

	
	/**
	 * Insert data to table domain_audit_keamanan with the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Repositories\Contracts\DomainAuditKeamananRepositoryInterface  $DomainAuditKeamananRepositoryInterface
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainAuditKeamanan(Request $request)
	{
		$saveData			= json_decode($this->domainAuditKeamananRepositoryInterface->simpanDataDomainAuditKeamanan($request));
		$type 				= $saveData->type;
		$message 			= $saveData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type, $saveData);
	}

	/**
	 * Store update tabel domain_audit_keamanan
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainAuditKeamanan(Request $request)
	{
		$updateData					= json_decode($this->domainAuditKeamananRepositoryInterface->updateDataDomainAuditKeamanan($request));
		$type 						= $updateData->type;
		$message 					= $updateData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type);
	}

	/**
	 * Delete Domain Audit Keamanan
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainAuditKeamanan(Request $request)
	{
		$deleteData		= json_decode($this->domainAuditKeamananRepositoryInterface->deleteDataDomainAuditKeamanan($request));
		$type 			= $deleteData->type;
		$message 		= $deleteData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type);
	}
	
	/** Get data domain audit keamanan*/
	public function searchDomainAuditKeamanan(Request $request)
	{
		return $this->domainAuditKeamananRepositoryInterface->searchDomainAuditKeamanan($request);
		//dd($request->all());
	}

	public function getMetadata(Request $request)
	{
		return $this->domainAuditKeamananRepositoryInterface->getMetadata($request);
	}
}
