<?php

namespace App\Http\Controllers;

use App\Http\Resources\{DomainInfrastrukturCloudMinResources, InstansiSPLPMinResources, MetaDataMinResources};
use Illuminate\Http\Request;
use App\Repositories\Contracts\DomainSplpRepositoryInterface;

class SistemPenghubungLayananPemerintahController extends Controller
{
  protected $infrastruktursplp;

  /**
   * GroupController constructor.
   *
   * @param DomainSplpRepositoryInterface
   */
  public function __construct(DomainSplpRepositoryInterface $infrastruktursplp)
  {
    $this->infrastruktursplp = $infrastruktursplp;
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function search(Request $request)
  {
    return $this->infrastruktursplp->search($request);
  }


  public function get_rail1(Request $request)
  {
    $infrastruktursplp = $this->infrastruktursplp->get_data_rail1($request);
    return DomainInfrastrukturCloudMinResources::collection($infrastruktursplp);
  }

  public function get_rail2(Request $request)
  {
    $infrastruktursplp = $this->infrastruktursplp->get_data_rail2($request);
    return DomainInfrastrukturCloudMinResources::collection($infrastruktursplp);
  }

  public function get_rail3(Request $request)
  {
    $infrastruktursplp = $this->infrastruktursplp->get_data_rail3($request);
    return DomainInfrastrukturCloudMinResources::collection($infrastruktursplp);
  }

  public function get_rail4(Request $request)
  {
    $infrastruktursplp = $this->infrastruktursplp->get_data_rail4($request);
    return DomainInfrastrukturCloudMinResources::collection($infrastruktursplp);
  }

  public function list_jenis(Request $request)
  {
    // dd($level);
    return $this->infrastruktursplp->get_list_jenis($request);
  }

  public function list_app(Request $request)
  {
    // dd($level);
    return $this->infrastruktursplp->get_list_app($request);
  }

  public function list_app_connected(Request $request)
  {
    // dd($level);
    return $this->infrastruktursplp->get_list_app_connected($request);
  }

  public function list_jip(Request $request)
  {
    // dd($level);
    return $this->infrastruktursplp->get_list_jip($request);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    // dd($request);
    $splp = $this->infrastruktursplp->save($request);

    $type = $splp ? 'success' : 'error';
    return $this->redirectResponse($request, trans("domain.actions_splp.store.{$type}"), $type, $splp);
  }

  /**
   * Delete domain infra splp
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function drop(Request $request)
  {
    $infrastruktursplp = $this->infrastruktursplp->delete($request);
    $type = $infrastruktursplp ? 'success' : 'error';
    return $this->redirectResponse($request, trans("domain.actions_splp.drop.{$type}"), $type);
  }

  /** Get data lihat infrastruktur cloud*/
  public function getDataInfrastrukturSplp($id, Request $request)
  {
    return $this->infrastruktursplp->dataInfrastrukturSplp($id, $request);
  }


  /**
   * Store a update created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function update($id, Request $request)
  {

    $infrastruktursplp = $this->infrastruktursplp->update($request, $id);

    $type = $infrastruktursplp ? 'success' : 'error';
    return $this->redirectResponse($request, trans("domain.actions_splp.update.{$type}"), $type, $infrastruktursplp);
  }

  public function get_instansi(Request $request)
  {
    return $this->infrastruktursplp->get_data_instansi($request);
  }

  public function get_metadata(Request $request)
  {
    return $this->infrastruktursplp->get_data_metadata($request);
    // return MetaDataMinResources::collection($infrastruktursplp);
  }

  /** Get data metadata jip*/
  public function get_metadata_detail(Request $request, $id)
  {
    return $this->infrastruktursplp->get_metadata_detail_data($request, $id);
  }

}
