<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Opd;
use App\Http\Resources\OpdResources;
use App\Repositories\Contracts\OpdRepositoryInterface;

class OpdRepository implements OpdRepositoryInterface
{
	/**
	 * Opd constructor
	 *
	 * @param Opd $opd
	 */
	public function __construct(Opd $opd)
	{
		$this->opd            = $opd;
	}

	/**
	 * Get's a data perangkat daerah
	 *
	 * @param int
	 * @return collection
	 */
	public function dataPerangkatDaerah(Request $request)
	{
		$query = $this->opd->isOpd()->select(['opd_id','nama_opd', 'akronim']);
		if(isset($request->opd_id)){
			$query->whereIn('opd_id',explode(';',$request->opd_id));
		}
		return $query->get();
	}

	
	/**
	 * Get's a data perangkat daerah bySlug
	 *
	 * @param int
	 * @return collection
	 */
	public function dataPerangkatDaerahBySlug(Request $request)
	{
		/**Domain layanan, domain periferal */
		return $this->opd->findBySlug($request->opd_id);		
		// return $this->opd->find($request->opd_id);		
	}
}
