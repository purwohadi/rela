<?php

namespace App\Http\Controllers;
use App\Models\Opd;

use Illuminate\Http\Request;
use App\Repositories\Contracts\ReferenceRepositoryInterface;

class OpdController extends Controller
{
  protected $opd;

  public function __construct(Opd $opd)
  {
    $this->opd = $opd;
  }

  public function list()
  {
    return $this->opd->all();
  }

  public function data()
  {
    $query = $this->opd->select(['nama_opd as kode', 'nama_opd as kode_nama', 'opd_id']);
		/* if(isset($request->opd_id)){
			$query->where('opd_id',$request->opd_id);
		} */
		return $query->get();
  }

}
