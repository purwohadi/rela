<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\DomainInfraSplp;
use App\Repositories\Contracts\DomainInfraSplpRepositoryInterface;

class DomainInfraSplpRepository implements DomainInfraSplpRepositoryInterface
{  
	protected $columns = [
	  ];

	/**
	 * DomainInfraSplpRepository constructor
	 *
	 * @param DomainInfraSplp $domainInfraSplp
	 */
	public function __construct(DomainInfraSplp $domainInfraSplp) 
	{
		$this->domainInfraSplp  = $domainInfraSplp;
	}

	/**
	 * Get's Domain Infra SPLP data by
	 *
	 * @return mixed
	 */
	public function getDataBy(Request $request)
	{		
		$query = $this->domainInfraSplp
					  ->select(DB::raw(''.$request->col.' as kode, '.$request->col.' as kode_nama'))
					  ->groupBy($request->col);
		return $query->get();
	}
}
