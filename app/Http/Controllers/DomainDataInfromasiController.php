<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\DomainDataRepositoryInterface;
use App\Http\Resources\{Radl1MinResources, Radl2MinResources, ProbisMinResources};

class DomainDataInfromasiController extends Controller
{

  protected $domaindata;

  /**
   * GroupController constructor.
   *
   * @param DomainDataRepositoryInterface
   */
  public function __construct(DomainDataRepositoryInterface $domaindata)
  {
    $this->domaindata = $domaindata;
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function search(Request $request)
  {
    // dd($request->opd_id);
    return $this->domaindata->search($request);
  }

  public function get_radl1(Request $request)
  {
    $domaindata = $this->domaindata->get_data_radl1($request);

    return $domaindata;
  }

  public function get_radl2(Request $request)
  {
    $domaindata = $this->domaindata->get_data_radl2($request);

    return $domaindata;
  }

  public function get_radl3(Request $request)
  {
    $domaindata = $this->domaindata->get_data_radl3($request);

    return $domaindata;
  }

  public function get_probis_terkait(Request $request)
  {
    // dd($request->opd_id);
    $domaindata = $this->domaindata->get_data_probis_terkait($request);

    return ProbisMinResources::collection($domaindata);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $saveData		= json_decode($this->domaindata->save($request));
	  $type 			= $saveData->type;
	  $message 		= $saveData->message;
	  $save 			= $saveData->save;
	  return $this->redirectResponse($request, trans("{$message}"), $type, $save);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function getDataInformasi($info_id, Request $request)
  {
    return $this->domaindata->dataInformasi($info_id, $request);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function get_detail_data(Request $request)
  {
    return $this->domaindata->get_detail_data($request);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function update($info_id, Request $request)
  {
    $updatedData	= json_decode($this->domaindata->update($request, $info_id));
	  $type 			= $updatedData->type;
	  $message 		= $updatedData->message;
	  $save 			= $updatedData->save;
	  return $this->redirectResponse($request, trans("{$message}"), $type, $save);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store_detail(Request $request)
  {
    $domaindata = $this->domaindata->save_detail($request);

    $type = $domaindata ? 'success' : 'error';
    return $this->redirectResponse($request, trans("domain.actions_detail_data_info.store.{$type}"), $type, $domaindata);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function getDetailDataInformasi($id, Request $request)
  {
    return $this->domaindata->get_detail_data_informasi($id, $request);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function get_probis_data($id, Request $request)
  {
    return $this->domaindata->get_probis_data_detail($id, $request);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function update_detail($id, Request $request)
  {
    // dd($info_id);
    $domaindata = $this->domaindata->update_detail($request, $id);

    $type = $domaindata ? 'success' : 'error';
    return $this->redirectResponse($request, trans("domain.actions_detail_data_info.update.{$type}"), $type, $domaindata);
  }

  /**
   * Delete detail data
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function drop_detail(Request $request)
  {
    $domaindata = $this->domaindata->delete_detail($request);
    $type = $domaindata ? 'success' : 'error';
    return $this->redirectResponse($request, trans("user.actions_detail_data_info.drop.{$type}"), $type);
  }

  /**
   * Delete detail data
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function drop(Request $request)
  {
    $domaindata = $this->domaindata->delete($request);
    $type = $domaindata ? 'success' : 'error';
    return $this->redirectResponse($request, trans("user.actions_data_info.drop.{$type}"), $type);
  }

  public function getDataUnique(Request $request)
  {
    return $this->domaindata->getDataUnique($request);
  }
}
