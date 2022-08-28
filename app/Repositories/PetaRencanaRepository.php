<?php

namespace App\Repositories;

use App\Http\Resources\RefInisiatifResource;
use App\Http\Resources\Roadmap\BidurResources;
use App\Http\Resources\Roadmap\InisiatifResources;
use App\Models\ProgramRoadmap;
use App\Models\Roadmap;
use App\Models\TmRoadmap;
use App\Repositories\Contracts\PetaRencanaRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetaRencanaRepository implements PetaRencanaRepositoryInterface
{
  	protected $roadmap;
	protected $inisiatif;
	
  	protected $columns = [
		'domain_arsitektur' => 'domain_arsitektur',
		'jenis_kesenjangan_app' => 'jenis_kesenjangan_app',
		'opd_id_pemilik' => 'opd_id_pemilik',
		'opd_pemilik' => 'opd_pemilik',
		'jenis_inisiatif' => 'jenis_inisiatif',
		'aplikasi' => 'aplikasi',
		'deskripsi_pekerjaan' => 'deskripsi_pekerjaan',
		'nama_inisiatif' => 'nama_inisiatif'
	];

	public function __construct(Roadmap $roadmap, TmRoadmap $inisiatif, ProgramRoadmap $program_roadmap)
	{
		$this->roadmap = $roadmap;
		$this->inisiatif = $inisiatif;
	}

	public function getInisiatif(Request $request)
	{
		$query = $this->roadmap->query();
        
		return RefInisiatifResource::collection($query->paginate($request->limit));
	}

	public function getProgramRoadmap(Request $request)
	{
		$query = $this->roadmap->query();
        
		return RefInisiatifResource::collection($query->paginate($request->limit));
	}

	public function getBidurByOPD(Request $request)
	{
		$query = DB::table('renstra_tujuan')->select('bidur_kode', 'bidur_nama', 'opd_id')->distinct();
		$opd_id = $request->opd_id;
		if ($opd_id) {
			if(str_contains($opd_id, 'O0') || str_contains($opd_id, 'O10')) {
				$query->whereNull('opd_id');	
			} else {
				$query->where('opd_id', $request->opd_id);
			}
		}
        
		return BidurResources::collection($query->get());
	}

	public function getDataRPDbyBidur(Request $request)
	{
		$opd_id = $request->opd_id;
		$query = DB::table('rpd_tujuan rpdt')->distinct()
		->select('rt.skpd_nama', 'rpds.tujuan_id', 'rpds.sasaran_id', 'rt.bidur_kode', 'rt.bidur_nama',
			'rpdt.tujuan', 'rpds.sasaran', 'rpds.target as indikator_sasaran', 'rpds.kondisi_2022', 'rpds.target_2023',
			'rpds.target_2024', 'rpds.target_2025', 'rpds.target_2026')
		->join('rpd_sasaran rpds', 'rpdt.tujuan_id', '=', 'rpds.tujuan_id')
		->join('renstra_tujuan rt', 'rpds.sasaran_id', '=', 'rt.sasaran_id');

		if ($opd_id && !(str_contains($opd_id, 'O0') || str_contains($opd_id, 'O10'))) { 
			$query->where('rt.opd_id', $opd_id); 
		}
		if ($request->bidur_kode) {
			$query->where('rt.bidur_kode', $request->bidur_kode);
		}
		
		return $query->get();
	}

	public function getRefInisiatif(Request $request)
	{
    	$query = $this->roadmap->query();
        
		if ($request->sort_by != null) 
		{
			$query->orderBy($this->columns[$request->sort_by], $request->sort_desc);
		}

		if ($request->has('search') && strlen(trim($request->search)) > 0) {
			$mapped = $this->columns;
			$query->where(function($sql) use ($request, $mapped) {
				$idx = 0;
				foreach ($request->column_filters as $column) {
					$clause = $idx == 0 ? 'where' : 'orWhere';
					$sql->{$clause}(DB::raw("upper({$mapped[$column]})"), 'like', '%' . strtoupper($request->search) . '%');
					++$idx;
				}
			});
		}
		if(isset($request->opd_id)){
			$query->where('opd_id_pemilik',$request->opd_id);
		}
		if(isset($request->jenis_inisiatif)){
			$query->where('jenis_inisiatif',$request->jenis_inisiatif);
		}
		return RefInisiatifResource::collection($query->paginate($request->limit));
  }

  	public function update(Request $request)
	{
		$input 		= $request->all();
		$user_id 	= auth()->user()->v_userid;
		$before = $this->inisiatif->findBySlug($input['id']);
		DB::beginTransaction();
		try
		{
			$data = ['kegiatan' => $input['kegiatan'], 
				'sub_kegiatan' => $input['sub_kegiatan'], 
				'nama_inisiatif' => $input['nama_inisiatif'], 
				'unit_pj' => $input['unit_pj'],
				'tahun_awal' => $input['tahun_awal'], 
				'tahun_akhir' => $input['tahun_akhir'],
				'tahun_implementasi' => $input['tahun_implementasi'], 
				'domain_arsitektur' => $input['domain'], 
				'program_id' => $input['program'],
				'opd_id' => $input['opd_id'],
				'updated_by' => $user_id,
				'updated_at' => date('Y-m-d H:i:s')
			];
			$updateData = $this->inisiatif->find($input['id']);
			$updateData->update($data);

			$save = $updateData;
			createLog(config('tables.master.tm_roadmap'), 'UPD', [
				'before' => collect($before)->sortKeys(),
				'after' => collect($updateData)->sortKeys()
			]);

			$type 				= 'success';
			$errorMsg			= '';
			$message			= 'Data Inisiatif Peta Rencana Berhasil Disimpan.';
			DB::commit();
		}catch(\Throwable $t){
			$type 				= 'error';
			$save 			= $t->getMessage();
			$message			= 'Data Inisiatif Peta Rencana Gagal Disimpan.';
			DB::rollBack();
		}

		$hasil = ['type'=>$type,
				'message' => $message,
				'save' => $save
				];
		return json_encode($hasil);
	}


	public function save($request)
	{
		$input 		= $request->all();
		$user_id 	= auth()->user()->v_userid;
		try
		{			

			$data = ['kegiatan' => $input['kegiatan'], 
				'sub_kegiatan' => $input['sub_kegiatan'], 
				'nama_inisiatif' => $input['nama_inisiatif'], 
				'unit_pj' => $input['unit_pj'],
				'tahun_awal' => $input['tahun_awal'], 
				'tahun_akhir' => $input['tahun_akhir'],
				'tahun_implementasi' => $input['tahun_implementasi'], 
				'domain_arsitektur' => $input['domain'], 
				'program_id' => $input['program'],
				'opd_id' => $input['opd_id'],
				'created_by' => $user_id,
				'created_at' => date('Y-m-d H:i:s')
			];

			$save = $this->inisiatif->create($data);
			createLog(config('tables.master.tm_roadmap'), 'INS', collect($save)->sortKeys());

			$type 				= 'success';
			$message			= 'Data Inisiatif Peta Rencana Berhasil Disimpan';

		}catch(\Throwable $t){
			$type 				= 'error';
			$save 				= $t->getMessage();
			$message			= 'Data Inisiatif Peta Rencana Gagal Disimpan';
		}

		$hasil = ['type'=>$type,
				'message' => $message,
				'save' => $save
				];
		return json_encode($hasil);
	}

	public function searchInisiatif(Request $request)
	{
    	$query = $this->inisiatif->active()
		->join('tr_kode_kepmen KK', 'tm_roadmap.kegiatan', '=', 'KK.kode_nomenklatur')
		->join('tr_kode_kepmen KSK', 'tm_roadmap.sub_kegiatan', '=', 'KSK.kode_nomenklatur')
		->join('tm_program_roadmap PR', 'tm_roadmap.program_id', '=', 'PR.id')
		->select(
			'tm_roadmap.id',
			'tm_roadmap.kegiatan', 
			'tm_roadmap.sub_kegiatan',
			'tm_roadmap.domain_arsitektur',
			'tm_roadmap.unit_pj',
			'tm_roadmap.tahun_implementasi',
			'tm_roadmap.nama_inisiatif',
			'tm_roadmap.program_id',
			'tm_roadmap.opd_id',
			'PR.program',
			'KK.nomenklatur_urusan as nama_kegiatan',
			'KSK.nomenklatur_urusan as nama_sub_kegiatan'
		);

		$query->orderBy('tm_roadmap.created_at', 'asc');

		if ($request->has('search') && strlen(trim($request->search)) > 0) {
			$mapped = $this->columns;
			$query->where(function($sql) use ($request, $mapped) {
				$idx = 0;
				foreach ($request->column_filters as $column) {
					$clause = $idx == 0 ? 'where' : 'orWhere';
					$sql->{$clause}(DB::raw("upper({$mapped[$column]})"), 'like', '%' . strtoupper($request->search) . '%');
					++$idx;
				}
			});
		}
		if(isset($request->opd_id)){
			$query->where('tm_roadmap.opd_id',$request->opd_id);
		}
		if(isset($request->domain)){
			$query->where('tm_roadmap.domain_arsitektur',$request->domain);
		}
		if(isset($request->program_id)){
			$query->where('tm_roadmap.program_id',$request->program_id);
		}
		if(isset($request->sub_kegiatan)){
			$query->where('tm_roadmap.sub_kegiatan',$request->sub_kegiatan);
		}
		return InisiatifResources::collection($query->paginate($request->limit));
	}

	public function delete($request)
	{
		try{
			$user_id = auth()->user()->v_userid;
			$data = ['deleted_by' => $user_id,
					 'deleted_at' => date('Y-m-d H:i:s')
					];
			$del = $this->inisiatif
						->where('id', $request->id)
						->update($data);
			createLog(config('tables.master.tm_roadmap'), 'DEL', collect($del)->sortKeys());

			$type 				= 'success';
			$message			= 'Data Inisiatif Peta Rencana Berhasil Dihapus	';
			$errorMsg			= '';
		}catch(\Throwable $t){
			$type 				= 'error';
			$message			= 'Data Inisiatif Peta Rencana Gagal Dihapus ';
			$errorMsg 			= $t->getMessage();
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}

	public function getKegiatanTree(Request $request) {
    	$query = $this->inisiatif
		->active()
		->join('tr_kode_kepmen KK', 'tm_roadmap.kegiatan', '=', 'KK.kode_nomenklatur')
		->join('tr_kode_kepmen KSK', 'tm_roadmap.sub_kegiatan', '=', 'KSK.kode_nomenklatur')
		->select('tm_roadmap.kegiatan', 'tm_roadmap.sub_kegiatan', 'KK.nomenklatur_urusan as nama_kegiatan', 'KSK.nomenklatur_urusan as nama_sub_kegiatan')
		->distinct();
        
		if(isset($request->domain)){
			$query->where('tm_roadmap.domain_arsitektur',$request->domain);
		}

		if(isset($request->opd_id)){
			$query->where('tm_roadmap.opd_id',$request->opd_id);
		}

		$data = array();
		foreach ($query->get() as $key => $value) {
			$kegiatan = $value->kegiatan.'-'.$value->nama_kegiatan;
			$sub_kegiatan = $value->sub_kegiatan.'-'.$value->nama_sub_kegiatan;
			
			
			$find = array_search($kegiatan, array_column(json_decode(json_encode($data),TRUE), 'kegiatan'));

			if (!$find) {
				$new_sub = array();
				array_push($new_sub, $sub_kegiatan);

				array_push($data, array(
					'kegiatan' => $kegiatan,
					'sub_kegiatan' => $new_sub
				));
			} else {
				array_push($data[$find]['sub_kegiatan'], $sub_kegiatan);
			}
		}

		return $data;
	}
}
