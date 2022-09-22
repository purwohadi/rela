<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use App\Models\Dpt2019;

use App\Repositories\Contracts\DashboardRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DashboardRepository implements DashboardRepositoryInterface
{
	protected $dpt2019;

	/**
	 * Dpt2019 constructor
	 *
	 * @param Dpt2019 $dpt2019
	 */
	public function __construct(Dpt2019 $dpt2019)
	{
		$this->dpt2019  				= $dpt2019;
	}

	/**
	 * Get's Domain Layanan by opd_id.
	 *
	 * @return mixed
	 */
	public function getDpt(Request $request)
	{
		$query 	= $this->dpt2019
					   ->select(DB::raw('provinsi,laki_perempuan'))
					   ->where('provinsi','<>','JUMLAH_TOTAL')
					   ->orderBy('no', 'asc')->get();
		// return $query;
		$label 	= [];
		$jml 	= [];
		foreach($query as $data){
			$label[] 	= $data->provinsi;
			$jml[] 	= $data->laki_perempuan;
		}
		$hasil = ['labels'	 => $label,
				  'jumlah_dpt'	 => $jml,
				 ];
		return json_encode($hasil);
	}

}
