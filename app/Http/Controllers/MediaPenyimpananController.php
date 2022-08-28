<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Resources\DomainInfrastrukturCloudMinResources;
use App\Repositories\Contracts\DomainInfraStorageRepositoryInterface;

class MediaPenyimpananController extends Controller
{
	protected $domainInfraStorageRepositoryInterface;

	/**
	 * MediaPenyimpananController constructor.
	 *
	 * @param DomainInfraStorageRepositoryInterface $permission
	 */
	public function __construct (DomainInfraStorageRepositoryInterface $domainInfraStorageRepositoryInterface) {
		$this->domainInfraStorageRepositoryInterface			= $domainInfraStorageRepositoryInterface;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function dataIntraStorage(Request $request)
	{
		return $this->domainInfraStorageRepositoryInterface->dataIntraStorage($request);
	}

	/**
	 * Insert data to domain_infra_storage with the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Repositories\Contracts\DomainInfraStorageRepositoryInterface  $domainInfraStorageRepositoryInterface
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainInfraStorage(Request $request)
	{
		$saveData			= json_decode($this->domainInfraStorageRepositoryInterface->simpanDataDomainInfraStorage($request));
		$type 				= $saveData->type;
		$message 			= $saveData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type, $saveData);
	}

	/**
	 * Store update tabel domain_infra_storage
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainInfraStorage(Request $request)
	{
		$updateData					= json_decode($this->domainInfraStorageRepositoryInterface->updateDataDomainInfraStorage($request));
		$type 						= $updateData->type;
		$message 					= $updateData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type);
	}

	/**
	 * Delete Domain infra Storage
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainInfraStorage(Request $request)
	{
		$deleteData		= json_decode($this->domainInfraStorageRepositoryInterface->deleteDataDomainInfraStorage($request));
		$type 			= $deleteData->type;
		$message 		= $deleteData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type);
	}

	/** Get data domain infra Storage*/
	public function searchIntraStorage(Request $request)
	{
		return $this->domainInfraStorageRepositoryInterface->searchIntraStorage($request);
	}

  public function get_rail1(Request $request)
  {
    $domainInfraStorageRepositoryInterface = $this->domainInfraStorageRepositoryInterface->get_data_rail1($request);
    return DomainInfrastrukturCloudMinResources::collection($domainInfraStorageRepositoryInterface);
  }

  public function get_rail2(Request $request)
  {
    $domainInfraStorageRepositoryInterface = $this->domainInfraStorageRepositoryInterface->get_data_rail2($request);
    return DomainInfrastrukturCloudMinResources::collection($domainInfraStorageRepositoryInterface);
  }

  public function get_rail3(Request $request)
  {
    $domainInfraStorageRepositoryInterface = $this->domainInfraStorageRepositoryInterface->get_data_rail3($request);
    return DomainInfrastrukturCloudMinResources::collection($domainInfraStorageRepositoryInterface);
  }

  public function get_rail4(Request $request)
  {
    $domainInfraStorageRepositoryInterface = $this->domainInfraStorageRepositoryInterface->get_data_rail4($request);
    return DomainInfrastrukturCloudMinResources::collection($domainInfraStorageRepositoryInterface);
  }

  /** Get data domain infra Storage*/
  public function metadataKeamananGet(Request $request)
  {
    // dd($request);
    return $this->domainInfraStorageRepositoryInterface->getMetadataKeamanan($request);
  }

  /** Get data domain infra Storage*/
  public function metadataSplpGet(Request $request)
  {
    // dd($request);
    return $this->domainInfraStorageRepositoryInterface->getMetadataSplp($request);
  }

  public function get_detail_instansi(Request $request)
  {
    return $this->domainInfraStorageRepositoryInterface->get_instansi($request);
  }
}
