<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Repositories\Contracts\DomainFasilitasRepositoryInterface;

class FasilitasController extends Controller
{
	protected $domainFasilitasRepositoryInterface;

	/**
	 * FasilitasController constructor.
	 *
	 * @param DomainFasilitasRepositoryInterface $permission
	 */
	public function __construct (DomainFasilitasRepositoryInterface $domainFasilitasRepositoryInterface) {
		$this->domainFasilitasRepositoryInterface			= $domainFasilitasRepositoryInterface;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getDomainCode(Request $request)
	{
		return $this->domainFasilitasRepositoryInterface->getDomainCode($request);
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function dataIntraFasilitas(Request $request)
	{
		return $this->domainFasilitasRepositoryInterface->dataIntraFasilitas($request);
	}
	
	/**
	 * Insert data to domain_infra_fasilitas with the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Repositories\Contracts\DomainFasilitasRepositoryInterface  $domainFasilitasRepositoryInterface
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainInfraFasilitas(Request $request)
	{
		$saveData			= json_decode($this->domainFasilitasRepositoryInterface->simpanDataDomainInfraFasilitas($request));
		$type 				= $saveData->type;
		$message 			= $saveData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type, $saveData);
	}

	/**
	 * Store update tabel domain_infra_fasilitas
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainInfraFasilitas(Request $request)
	{
		$updateData					= json_decode($this->domainFasilitasRepositoryInterface->updateDataDomainInfraFasilitas($request));
		$type 						= $updateData->type;
		$message 					= $updateData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type);
	}

	/**
	 * Delete Domain infra fasilitas
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainInfraFasilitas(Request $request)
	{
		$deleteData		= json_decode($this->domainFasilitasRepositoryInterface->deleteDataDomainInfraFasilitas($request));
		$type 			= $deleteData->type;
		$message 		= $deleteData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type);
	}
	
	/** Get data domain infra fasilitas*/
	public function searchIntraFasilitas(Request $request)
	{
		return $this->domainFasilitasRepositoryInterface->searchIntraFasilitas($request);
	}
	 
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getDataBy(Request $request)
	{
		return $this->domainFasilitasRepositoryInterface->getDataBy($request);
	}

	/** Get data perangkat daerah instansi lain*/
	public function dataPerangkatDaerahInstansiLain(Request $request)
	{
		return $this->domainFasilitasRepositoryInterface->dataPerangkatDaerahInstansiLain($request);
	}
}
