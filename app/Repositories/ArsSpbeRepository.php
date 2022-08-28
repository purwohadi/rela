<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\ArsSpbe;
use App\Http\Resources\OpdResources;
use App\Repositories\Contracts\ArsSpbeRepositoryInterface;

class ArsSpbeRepository implements ArsSpbeRepositoryInterface
{  
	/**
	 * Opd constructor
	 *
	 * @param Opd $opd
	 */
	public function __construct(ArsSpbe $arsSpbe) 
	{
		$this->arsSpbe	= $arsSpbe;
	}

	public function searchRal(Request $request)
	{
		$query = $this->arsSpbe
					  ->select(['kode','kode_nama'])
					  ->where('kategori',$request->kategori)
					  ->orderBy('kode','asc');
		if(isset($request->tingkat)){
			$query->where('tingkat',$request->tingkat);
		}

		if(isset($request->kode) && $request->kode != ''){
			$kode = $request->kode;
			if(substr($request->kode,0,1) == 'R'){
				$kode = substr($request->kode,4);
			}
			$query->where(function ($sql) use ($kode) {
				$sql->where(function ($sql1)  use ($kode){
					$sql1->whereRaw("substr(kode,0,1) = 'R'");
					$sql1->whereRaw("substr(kode,5) like '".$kode."%' ");
				});
				$sql->orWhere(function ($sql2)  use ($kode){
					$sql2->whereRaw("substr(kode,0,1) <> 'R'");
					$sql2->whereRaw("kode like '".$kode."%' ");
				});
			});
		}
		// if(isset($request->kode_nama)){
		// 	$query->where('kode_nama', $request->kode_nama);
		// }
		
		if(isset($request->kode_nama)){
			$query->where('kode', $request->kode_nama);
		}
		// dd($query->toSql());
		return $query->get();
	}

	public function searchRef(Request $request)
	{
		$query = $this->arsSpbe
					  ->select(['kode','kode_nama'])
					  ->where('kategori',$request->kategori);
		if(isset($request->tingkat)){
			$query->where('tingkat',$request->tingkat);
		}

		if(isset($request->kode) && $request->kode != ''){
			$query->where('kode', 'like', ''.$request->kode.'%');
		}
		if(isset($request->kode_nama)){
			$query->where('kode_nama', $request->kode_nama);
		}
		return $query->get();
	}
}
