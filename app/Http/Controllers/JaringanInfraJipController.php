<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Repositories\Contracts\DomainInfraJipRepositoryInterface;

class JaringanInfraJipController extends Controller
{
	protected $domainInfraJipRepositoryInterface;

	/**
	 * JaringanInfraJipController constructor.
	 *
	 * @param DomainInfraJipRepositoryInterface $permission
	 */
	public function __construct (DomainInfraJipRepositoryInterface $domainInfraJipRepositoryInterface) {
		$this->domainInfraJipRepositoryInterface			= $domainInfraJipRepositoryInterface;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function dataIntraPemerintah(Request $request)
	{
		return $this->domainInfraJipRepositoryInterface->dataIntraPemerintah($request);
	}


	/**
	 * Insert data to domain_infra_jip with the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Repositories\Contracts\DomainInfraJipRepositoryInterface  $domainInfraJipRepositoryInterface
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainInfraJip(Request $request)
	{
		$saveData			= json_decode($this->domainInfraJipRepositoryInterface->simpanDataDomainInfraJip($request));
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
	public function updateDataDomainInfraJip(Request $request)
	{
		$updateData					= json_decode($this->domainInfraJipRepositoryInterface->updateDataDomainInfraJip($request));
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
	public function deleteDataDomainInfraJip(Request $request)
	{
		$deleteData		= json_decode($this->domainInfraJipRepositoryInterface->deleteDataDomainInfraJip($request));
		$type 			= $deleteData->type;
		$message 		= $deleteData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type);
	}

	/** Get data domain infra jip*/
	public function searchIntraPemerintah (Request $request)
	{
		return $this->domainInfraJipRepositoryInterface->searchIntraPemerintah($request);
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getDataBy(Request $request)
	{
		return $this->domainInfraJipRepositoryInterface->getDataBy($request);
	}

	/** Get data perangkat daerah*/
	public function dataPerangkatDaerah(Request $request)
	{
		return $this->domainInfraJipRepositoryInterface->dataPerangkatDaerah($request);
	}

	/** Get data perangkat daerah nama pemilik*/
	public function dataPerangkatDaerahPemilik(Request $request)
	{
		return $this->domainInfraJipRepositoryInterface->dataPerangkatDaerahPemilik($request);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getDomainCode(Request $request)
	{
		return $this->domainInfraJipRepositoryInterface->getDomainCode($request);
	}

}
