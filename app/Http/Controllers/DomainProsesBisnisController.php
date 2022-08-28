<?php

namespace App\Http\Controllers;

use App\Http\Resources\{DomainProsesBisnisMinResources, Rabl2MinResources, Rabl3MinResources, ProgramMinResources, Rabl4MinResources, DomainProsesBisnisRablMinResources};
use App\Models\{DomainProses, UserGroup};
use Illuminate\Http\Request;
use App\Repositories\Contracts\DomainProsesBisnisRepositoryInterface;

class DomainProsesBisnisController extends Controller
{
  protected $domainprosesbisnis;

  /**
   * GroupController constructor.
   *
   * @param DomainProsesBisnisInterface
   */
  public function __construct(DomainProsesBisnisRepositoryInterface $domainprosesbisnis)
  {
    $this->domainprosesbisnis = $domainprosesbisnis;
  }

  public function index(){
    echo "ini tampilan domain proses bisnis";
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function search(Request $request)
  {
    return $this->domainprosesbisnis->search($request);
  }

  public function get_rabl(Request $request, $level = 1)
  {
    $domainprosesbisnis = $this->domainprosesbisnis->get_data_rabl($request, $level);

    return DomainProsesBisnisMinResources::collection($domainprosesbisnis);
  }

  public function get_rabl2(Request $request)
  {
    $domainprosesbisnis = $this->domainprosesbisnis->get_data_rabl_2($request);

    return Rabl2MinResources::collection($domainprosesbisnis);
  }

  public function get_rabl3(Request $request)
  {
    $domainprosesbisnis = $this->domainprosesbisnis->get_data_rabl_3($request);

    return Rabl3MinResources::collection($domainprosesbisnis);
  }

  public function get_program(Request $request)
  {
    return $this->domainprosesbisnis->get_data_program($request);

    // return ProgramMinResources::collection($domainprosesbisnis);
  }

  public function get_rabl4(Request $request)
  {
    return $this->domainprosesbisnis->get_data_rabl_4($request);

    // return Rabl4MinResources::collection($domainprosesbisnis);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $rabl = json_decode($this->domainprosesbisnis->save($request));
    $type         = $rabl->type;
    return $this->redirectResponse($request, trans("domain.actions.store.{$type}"), $type, $rabl);
  }

  /**
   * Delete domain proses
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function drop(Request $request)
  {
    $domainprosesbisnis = json_decode($this->domainprosesbisnis->delete($request));
    $type = $domainprosesbisnis->type;
    $message = $domainprosesbisnis->message ? $domainprosesbisnis->message : null;
    return $this->redirectResponse($request, trans("{$message}"), $type);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function getDataDomainProses($proses_id, Request $request)
  {
    $domainprosesbisnis = $this->domainprosesbisnis->dataProsesBisnis($proses_id, $request);

    return DomainProsesBisnisRablMinResources::collection($domainprosesbisnis);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function update($proses_id, Request $request)
  {
    // $find = DomainProses::where('v_userid', $request->user_id)->first();
    // if ($find) {
    //   return $this->redirectResponse($request, 'Domain Proses Sudah Ada!', 'error', 'duplicate');
    // }

    // $input = $request->only(['rabl1']);
    $rabl = $this->domainprosesbisnis->update($request, $proses_id);

    $type = $rabl ? 'success' : 'error';
    return $this->redirectResponse($request, trans("domain.actions.store.{$type}"), $type, $rabl);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function get_urusan(Request $request)
  {
    return $this->domainprosesbisnis->get_urusan($request);
  }

  }
