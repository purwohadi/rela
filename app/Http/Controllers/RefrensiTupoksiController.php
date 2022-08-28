<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\RefrensiTupoksiRepositoryInterface;
use App\Http\Resources\{RefrensiTupoksiResources};

class RefrensiTupoksiController extends Controller
{
  protected $reftupoksi;

  /**
   * GroupController constructor.
   *
   * @param RefrensiKemendagriRepositoryInterface
   */
  public function __construct(RefrensiTupoksiRepositoryInterface $reftupoksi)
  {
    $this->reftupoksi = $reftupoksi;
  }

  // public function index()
  // {
  //   echo "ini tampilan domain proses bisnis";
  // }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function search(Request $request)
  {
    return $this->reftupoksi->search($request);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function get_option(Request $request)
  {
    return $this->reftupoksi->get_option($request);
  }
}
