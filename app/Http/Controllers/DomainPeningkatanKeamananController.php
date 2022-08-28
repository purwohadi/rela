<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\DomainPeningkatanKeamananRepositoryInterface;

class DomainPeningkatanKeamananController extends Controller
{
    	/**
	 * DomainPeningkatanKeamananController constructor.
	 *
	 * @param DomainPeningkatanKeamananRepositoryInterface $permission
	 */
	public function __construct (DomainPeningkatanKeamananRepositoryInterface $domainPeningkatanKeamananRepositoryInterface) {
		$this->domainPeningkatanKeamananRepositoryInterface			= $domainPeningkatanKeamananRepositoryInterface;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function dataPeningkatanKeamanan(Request $request)
	{
		return $this->domainPeningkatanKeamananRepositoryInterface->dataPeningkatanKeamanan($request);
        //return 'dd($request->all())';
        //return 'ini controller Peningkatan keamanan';
	}

	
	/**
	 * Insert data to domain_peningkatan_keamanan with the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Repositories\Contracts\DomainPeningkatanKeamananRepositoryInterface  $DomainPeningkatanKeamananRepositoryInterface
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainPeningkatanKeamanan(Request $request)
	{
		$saveData			= json_decode($this->domainPeningkatanKeamananRepositoryInterface->simpanDataDomainPeningkatanKeamanan($request));
		$type 				= $saveData->type;
		$message 			= $saveData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type, $saveData);
	}

	/**
	 * Store update tabel domain_peningkatan_keamanan
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainPeningkatanKeamanan(Request $request)
	{
		$updateData					= json_decode($this->domainPeningkatanKeamananRepositoryInterface->updateDataDomainPeningkatanKeamanan($request));
		$type 						= $updateData->type;
		$message 					= $updateData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type);
	}

	/**
	 * Delete Domain Peningkatan Keamanan
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainPeningkatanKeamanan(Request $request)
	{
		$deleteData		= json_decode($this->domainPeningkatanKeamananRepositoryInterface->deleteDataDomainPeningkatanKeamanan($request));
		$type 			= $deleteData->type;
		$message 		= $deleteData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type);
	}
	
	/** Get data domain peningkatan keamanan*/
	public function searchDomainPeningkatanKeamanan(Request $request)
	{
		return $this->domainPeningkatanKeamananRepositoryInterface->searchDomainPeningkatanKeamanan($request);
		//dd($request->all());
	}

	public function getMetadataApp(Request $request)
	{
		return $this->domainPeningkatanKeamananRepositoryInterface->getMetadataApp($request);
	}

	public function getMetadataNetdev(Request $request)
	{
		return $this->domainPeningkatanKeamananRepositoryInterface->getMetadataNetdev($request);
	}
}
