<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\TmProses;
use App\Models\VwDomainProses;
use App\Http\Resources\OpdResources;
use App\Repositories\Contracts\DomainProsesRepositoryInterface;

class DomainProsesRepository implements DomainProsesRepositoryInterface
{  
	protected $tmProses;
	protected $viewDomainProses;

	/**
	 * DomainProsesRepository constructor
	 *
	 * @param TmProses $tmProses
	 */
	public function __construct(TmProses $tmProses,
								VwDomainProses $viewDomainProses) 
	{
		$this->tmProses	= $tmProses;
		$this->viewDomainProses = $viewDomainProses;
	}

	/**
	 * Get's a data proses bisnis
	 *
	 * @param int
	 * @return collection
	 */
	public function dataProsesBisnis(Request $request)
	{
		$query = $this->viewDomainProses
					  ->select(['proses_id', 'rab_level4','kode_lev4'])
					  ->groupBy(DB::raw('proses_id, rab_level4,kode_lev4'));
					  
		if(isset($request->proses_id)){
			$query->where('proses_id',$request->proses_id);
		}
		if(isset($request->opd_id)){
			$query->where('opd_id',$request->opd_id);
		}
		return $query->get();
	}
}
