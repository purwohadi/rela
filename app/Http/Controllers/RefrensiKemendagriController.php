<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\RefrensiKemendagriRepositoryInterface;

class RefrensiKemendagriController extends Controller
{
  protected $refkemendagri;

  /**
   * GroupController constructor.
   *
   * @param RefrensiKemendagriRepositoryInterface
   */
  public function __construct(RefrensiKemendagriRepositoryInterface $refkemendagri)
  {
    $this->refkemendagri = $refkemendagri;
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
    return $this->refkemendagri->search($request);
  }

  public function getRefProgram(Request $request)
  {
    return $this->refkemendagri->getRefProgram($request);
  }

  public function getRefKegiatan(Request $request)
  {
    return $this->refkemendagri->getRefKegiatan($request);
  }

  public function getRefSubKegiatan(Request $request)
  {
    return $this->refkemendagri->getRefSubKegiatan($request);
  }
}
