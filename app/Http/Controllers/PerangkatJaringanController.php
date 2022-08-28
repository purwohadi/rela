<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Resources\DomainInfrastrukturCloudMinResources;
use App\Repositories\Contracts\DomainInfraNetdevRepositoryInterface;

class PerangkatJaringanController extends Controller
{
	protected $domainInfraNetdevRepositoryInterface;

	/**
	 * PerangkatJaringanController constructor.
	 *
	 * @param DomainInfraNetdevRepositoryInterface $permission
	 */
	public function __construct (DomainInfraNetdevRepositoryInterface $domainInfraNetdevRepositoryInterface) {
		$this->domainInfraNetdevRepositoryInterface			= $domainInfraNetdevRepositoryInterface;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function dataIntraNetdev(Request $request)
	{
		return $this->domainInfraNetdevRepositoryInterface->dataIntraNetdev($request);
	}

	/**
	 * Insert data to domain_infra_netdev with the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Repositories\Contracts\DomainInfraNetdevRepositoryInterface  $domainInfraNetdevRepositoryInterface
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainInfraNetdev(Request $request)
	{
		$saveData			= json_decode($this->domainInfraNetdevRepositoryInterface->simpanDataDomainInfraNetdev($request));
		$type 				= $saveData->type;
		$message 			= $saveData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type, $saveData);
	}

	/**
	 * Store update tabel domain_infra_netdev
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainInfraNetdev(Request $request)
	{
		$updateData					= json_decode($this->domainInfraNetdevRepositoryInterface->updateDataDomainInfraNetdev($request));
		$type 						= $updateData->type;
		$message 					= $updateData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type);
	}

	/**
	 * Delete Domain infra netdev
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainInfraNetdev(Request $request)
	{
		$deleteData		= json_decode($this->domainInfraNetdevRepositoryInterface->deleteDataDomainInfraNetdev($request));
		$type 			= $deleteData->type;
		$message 		= $deleteData->message;
		return $this->redirectResponse($request, trans("{$message}"), $type);
	}

	/** Get data domain infra netdev*/
	public function searchIntraNetdev(Request $request)
	{
		return $this->domainInfraNetdevRepositoryInterface->searchIntraNetdev($request);
	}


  public function get_rail1(Request $request)
  {
    $domainInfraNetdevRepositoryInterface = $this->domainInfraNetdevRepositoryInterface->get_data_rail1($request);
    return DomainInfrastrukturCloudMinResources::collection($domainInfraNetdevRepositoryInterface);
  }

  public function get_rail2(Request $request)
  {
    $domainInfraNetdevRepositoryInterface = $this->domainInfraNetdevRepositoryInterface->get_data_rail2($request);
    return DomainInfrastrukturCloudMinResources::collection($domainInfraNetdevRepositoryInterface);
  }

  public function get_rail3(Request $request)
  {
    $domainInfraNetdevRepositoryInterface = $this->domainInfraNetdevRepositoryInterface->get_data_rail3($request);
    return DomainInfrastrukturCloudMinResources::collection($domainInfraNetdevRepositoryInterface);
  }

  public function get_rail4(Request $request)
  {
    $domainInfraNetdevRepositoryInterface = $this->domainInfraNetdevRepositoryInterface->get_data_rail4($request);
    return DomainInfrastrukturCloudMinResources::collection($domainInfraNetdevRepositoryInterface);
  }

  public function get_instansi1(Request $request)
  {
    return $this->domainInfraNetdevRepositoryInterface->get_data_instansi1($request);
  }

  public function get_instansi2(Request $request)
  {
    return $this->domainInfraNetdevRepositoryInterface->get_data_instansi2($request);
  }

  /** Get data metadata jip*/
  public function get_metadata_jip(Request $request, $id)
  {
    return $this->domainInfraNetdevRepositoryInterface->get_metadata_jip_data($request, $id);
  }

  /** Get data metadata jip*/
  public function get_metadata_fasilitas(Request $request, $id)
  {
    return $this->domainInfraNetdevRepositoryInterface->get_metadata_fasilitas_data($request, $id);
  }

  /** Get data metadata jip*/
  public function dataPerangkatDaerah(Request $request)
  {
    return $this->domainInfraNetdevRepositoryInterface->get_data_opd($request);
  }

}
