<?php

namespace App\Http\Controllers;

use App\Http\Resources\DomainInfrastrukturCloudMinResources;
use Illuminate\Http\Request;
use App\Repositories\Contracts\DomainInfrastrukturCloudRepositoryInterface;

class DomainInfrastrukturCloudController extends Controller
{
  protected $domaininfrastrukturcloud;

  /**
   * GroupController constructor.
   *
   * @param DomainInfrastrukturCloudRepositoryInterface
   */
  public function __construct(DomainInfrastrukturCloudRepositoryInterface $domaininfrastrukturcloud)
  {
    $this->domaininfrastrukturcloud = $domaininfrastrukturcloud;
  }

  public function index()
  {
    echo "ini tampilan domain proses bisnis";
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function search(Request $request)
  {
    return $this->domaininfrastrukturcloud->search($request);
  }

  public function get_rail(Request $request, $level = 1)
  {
    $domaininfrastrukturcloud = $this->domaininfrastrukturcloud->get_data_rail($request, $level);

    return DomainInfrastrukturCloudMinResources::collection($domaininfrastrukturcloud);
  }

  public function get_rail1(Request $request)
  {
    $domaininfrastrukturcloud = $this->domaininfrastrukturcloud->get_data_rail1($request);
    return DomainInfrastrukturCloudMinResources::collection($domaininfrastrukturcloud);
  }

  public function get_rail2(Request $request)
  {
    $domaininfrastrukturcloud = $this->domaininfrastrukturcloud->get_data_rail2($request);
    return DomainInfrastrukturCloudMinResources::collection($domaininfrastrukturcloud);
  }

  public function get_rail3(Request $request, $rail3)
  {
    $domaininfrastrukturcloud = $this->domaininfrastrukturcloud->get_data_rail3($request, $rail3);
    return DomainInfrastrukturCloudMinResources::collection($domaininfrastrukturcloud);
  }

  public function list_instansi(Request $request)
  {

    return $this->domaininfrastrukturcloud->get_list_instansi($request);
  }

  public function list_tipe(Request $request)
  {

    return $this->domaininfrastrukturcloud->get_list_tipe($request);
  }

  public function list_owner(Request $request)
  {

    return $this->domaininfrastrukturcloud->get_list_owner($request);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $saveData		= json_decode($this->domaininfrastrukturcloud->save($request));
	  $type 			= $saveData->type;
	  $message 		= $saveData->message;
	  $save 			= $saveData->save;
	  return $this->redirectResponse($request, trans("{$message}"), $type, $save);
  }

  /** Get data lihat infrastruktur cloud*/
  public function getDataInfrastrukturCloud($id, Request $request)
  {
    return $this->domaininfrastrukturcloud->dataInfrastrukturCloud($id, $request);
  }

  /**
   * Delete domain proses
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function drop(Request $request)
  {
    $domaininfrastrukturcloud = $this->domaininfrastrukturcloud->delete($request);
    $type = $domaininfrastrukturcloud ? 'success' : 'error';
    return $this->redirectResponse($request, trans("domain.actions_cloud.drop.{$type}"), $type);
  }

  /**
   * Store a update created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function update($id, Request $request)
  {

    $saveData		= json_decode($this->domaininfrastrukturcloud->update($request, $id));
	  $type 			= $saveData->type;
	  $message 		= $saveData->message;
	  $save 			= $saveData->save;
	  return $this->redirectResponse($request, trans("{$message}"), $type, $save);
  }

  /** Get data domain infra Storage*/
  public function get_metadata_detail(Request $request, $id)
  {

    return $this->domaininfrastrukturcloud->get_metadata_detail_data($request,$id);
  }

  /** Get data perangkat daerah*/
  public function dataPerangkatDaerah(Request $request)
  {
    return $this->domaininfrastrukturcloud->dataPerangkatDaerah($request);
  }
}
