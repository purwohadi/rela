<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\DomainLayanan;
use App\Models\Layanan;
use App\Models\LayananDetail;
use App\Models\LayananProses;
use App\Models\ViewDomainLayanan;
use App\Models\ViewDomainAplikasiLayanan;
use App\Models\ViewJabatanTropd;

use App\Http\Resources\DomainLayananResources;
use App\Repositories\Contracts\DomainLayananRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DomainLayananRepository implements DomainLayananRepositoryInterface
{  
	protected $layanan, 
			  $layananDetail, 
			  $layananProses, 
			  $viewDomainLayanan, 
			  $viewDomainAplikasiLayanan,
			  $viewJabatanTropd;

	protected $columns = [
		'layanan_id' => 'layanan_id',
		'ral_level_1' => 'ral_level_1',
		'ral_level_2' => 'ral_level_2',
		'ral_level_3' => 'ral_level_3',
		'nama_layanan' => 'nama_layanan',
		'opd_id' => 'opd_id',
		'domain_code' => 'domain_code',
	  ];

	  protected $columnsDetail = [
		'proses_id' => 'proses_id',
		'fungsi_layanan' => 'fungsi_layanan',
		'pelaksana_level1' => 'pelaksana_level1',
		'pelaksana_level2' => 'pelaksana_level2',
		'target_layanan' => 'target_layanan',
		'unit_delegasi' => 'unit_delegasi',
	  ];

	/**
	 * DomainLayanan constructor
	 *
	 * @param DomainLayanan $domainLayanan
	 */
	public function __construct(DomainLayanan $domainLayanan,
								Layanan $layanan,
								LayananDetail $layananDetail,
								LayananProses $layananProses,
								ViewDomainLayanan $viewDomainLayanan,
								ViewDomainAplikasiLayanan $viewDomainAplikasiLayanan,
								ViewJabatanTropd $viewJabatanTropd) 
	{
		$this->domainLayanan  				= $domainLayanan;
		$this->layanan						= $layanan;
		$this->layananDetail				= $layananDetail;
		$this->layananProses				= $layananProses;
		$this->viewDomainLayanan 			= $viewDomainLayanan;
		$this->viewDomainAplikasiLayanan 	= $viewDomainAplikasiLayanan;
		$this->viewJabatanTropd				= $viewJabatanTropd;
	}

	/**
	 * Get's Domain Layanan by opd_id.
	 *
	 * @return mixed
	 */
	public function getDomainLayanan(Request $request)
	{		
		$query = $this->viewDomainLayanan
					  ->select(DB::raw('layanan_id,ral_level_1, 
										ral_level_2, 
										ral_level_3, 
										ral_level_4, 
										nama_layanan,
										domain_code,
										opd_id'))
					  ->orderBy('layanan_id', 'desc')
					  ->where('layanan_deleted_at',null)
					  ->groupBy(DB::raw('layanan_id, 
					  					 ral_level_1, 
										 ral_level_2, 
										 ral_level_3, 
										 ral_level_4, 
										 nama_layanan,
										 domain_code,
										 opd_id'));
		
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
		// if(isset($request->opd_id)){
			$query->where('opd_id',$request->opd_id);
		// }
		return $query->paginate($request->limit);
		// return DomainLayananResources::collection($query->paginate($request->limit));
	}

	public function getDataLayananUnique(Request $request)
	{		
		$query = $this->layanan
			->select('tm_layanan.layanan_id', 'tm_layanan.nama_layanan', 'tm_layanan.opd_id',  'tr_opd.akronim')
			->leftJoin('TR_OPD', 'tm_layanan.opd_id', 'tr_opd.opd_id')
			->orderBy('tm_layanan.layanan_id', 'desc')
			->active();

		if(isset($request->opd_id)){
			$query->where('tm_layanan.opd_id',$request->opd_id);
		}
		
		return $query->get();
	}

	public function deleteDataDomainLayanan($request)
	{
		$cekLayananData = $this->viewDomainAplikasiLayanan
							->select(DB::raw('rownum||\'. \'||opd_pemilik ||\' - \'||nama_apl as nama_duplikat'))
							->where('layanan_id',$request->data['id'])					   
							->where('aplikasi_deleted_at',null)
							->get();
		
		$arrlayananAplikasi = '';
		foreach($cekLayananData as $dataLayanan){
			$arrlayananAplikasi = $arrlayananAplikasi.$dataLayanan['nama_duplikat']." <br>";
		}

		DB::beginTransaction();
		if(count($cekLayananData) > 0)
		{
			$errorMsg 	= '';
			$type 		= 'error';
			$message	= 'Mohon menghapus layanan ini terlebih dahulu di domain aplikasi berikut: <br>'.$arrlayananAplikasi;
		}
		else
		{
			try{			
				$user_id 	= auth()->user()->v_userid;
				/**TM_LAYANAN*/
				$data = ['deleted_by' => $user_id,
						'deleted_at' => date('Y-m-d H:i:s')
						];

				$del = $this->layanan
							->where('layanan_id',$request->data['id'])
							->update($data);
				createLog(config('tables.master.layanan'), 'DEL', collect($del)->sortKeys());
				
				/**TM_LAYANAN_DETAIL */
				$dataLDelLayananDetail = ['deleted_by' => $user_id,
										'deleted_at' => date('Y-m-d H:i:s')
										];

				$delLayananDetail = $this->layananDetail
										->where('layanan_id', $request->data['id'])
										->update($dataLDelLayananDetail);
				createLog(config('tables.master.layanan_detail'), 'DEL', collect($delLayananDetail)->sortKeys());
				
				/**TM_LAYANAN_PROSES */
				$dataLDelLayananProses = ['deleted_by' => $user_id,
										'deleted_at' => date('Y-m-d H:i:s')
										];

				$delLayananProses = $this->layananProses
										->where('layanan_id', $request->data['id'])
										->update($dataLDelLayananProses);
				createLog(config('tables.master.layanan_proses'), 'DEL', collect($delLayananProses)->sortKeys());

				DB::commit();
				$type 				= 'success';
				$message			= 'Data Hapus Domain Layanan Berhasil Dihapus';
				$errorMsg			= '';
			}catch(\Throwable $t){
				$type 				= 'error';
				$message			= 'Data Hapus Domain Layanan Gagal Dihapus ';
				$errorMsg 			= $t->getMessage();
				DB::rollBack();
			}
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}

	/**
	 * Save Update Data Domain Layanan .
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainLayanan( $request){
		$input 		= $request->all();
		$user_id 	= auth()->user()->v_userid;
		$cekLayanan = $this->layanan
						   ->where('opd_id',$input['opd_id'])
						   ->where(DB::raw('upper(nama_layanan)'),strtoupper($input['nama_layanan']))						   
						   ->where('deleted_at',null)
						   ->where('layanan_id','!=',$input['layanan_id'])
						   ->first();
		DB::beginTransaction();
		if($cekLayanan)
		{
			$errorMsg 	= '';
			$type 		= 'error';
			$message	= 'Layanan gagal disimpan. Nama layanan sudah terdaftar';
		}
		else
		{
			try
			{
				$data = ['ral_level_3' => $input['ral_level_3']['kode'], 
						'ral_level_2' => $input['ral_level_2']['kode'], 
						'ral_level_1' => $input['ral_level_1']['kode'], 
						'nama_layanan' => $input['nama_layanan'], 
						'tujuan_layanan' => $input['tujuan_layanan'], 
						'updated_by' => $user_id,
						];

				$post = $this->layanan
							->where('layanan_id',$input['layanan_id'])
							->update($data);

				createLog(config('tables.master.layanan'), 'UPD', collect($post)->sortKeys());

				/**Save tm_layanan_proses */			
				$dataLDelLayananProses = ['deleted_by' => $user_id,
											'deleted_at' => date('Y-m-d H:i:s')
											];

				$this->layananProses
					->where('layanan_id', $input['layanan_id'])
					->update($dataLDelLayananProses);
				$probis 	= collect($request->prosesBisnis);
				$probis->each(function ($item, $key) use($request, $user_id ) 
				{
					$where 			  = ['proses_id' => $item['proses_id'], 'layanan_id' => $request->layanan_id];
					$cekLayananProses = $this->layananProses
											->where('proses_id', $item['proses_id'])
											->where('layanan_id', $request->layanan_id)
											->get();
					if($cekLayananProses->count() > 0)
					{
						$dataLayDetilProses = ['deleted_by' => null,
											'deleted_at' => null
											];
						$del = $this->layananProses
									->where($where)
									->update($dataLayDetilProses);
						createLog(config('tables.master.layanan_proses'), 'DEL', collect($del)->sortKeys());
					}
					else
					{
						$dataLayDetilProses = ['layanan_id' => $request->layanan_id,
											'proses_id' => $item['proses_id'],
											];
						$saveLayananDetilProses	= $this->layananProses
													->create($dataLayDetilProses);
						createLog(config('tables.master.layanan_proses'), 'INS', collect($saveLayananDetilProses)->sortKeys());
					}				
				});		
				
				$type 				= 'success';
				$errorMsg			= '';
				$message			= 'Data Ubah Domain Layanan Berhasil Disimpan	';
				DB::commit();
			}catch(\Throwable $t){
				$type 				= 'error';
				$errorMsg 			= $t->getMessage();
				$message			= 'Data Ubah Domain Layanan Gagal Disimpan '.$errorMsg;
				DB::rollBack();
			}
		}
		
		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}

	/**
	 * Save Data Domain Layanan.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainLayanan($request){
		$input 		= $request->all();
		$user_id 	= auth()->user()->v_userid;
		
		$cekLayanan = $this->layanan
						   ->where('opd_id',$input['opd_id'])
						   ->where('nama_layanan',strtoupper($input['nama_layanan']))						   
						   ->where('deleted_at',null)
						   ->first();
		if(!$cekLayanan)	
		{
			try
			{			
				/**Save tm_layanan */
				$dataLayanan = ['opd_id' => $input['opd_id'], 
								'ral_level_1' => $input['ral_level_1']['kode'], 
								'ral_level_2' => $input['ral_level_2']['kode'],
								'ral_level_3' => $input['ral_level_3']['kode'],  
								'nama_layanan' => $input['nama_layanan'],  
								'tujuan_layanan' => $input['tujuan_layanan'], 
								'created_by' => $user_id
								];
							
				$saveLayanan			= $this->layanan->create($dataLayanan);	
				$lastInsertedLayananId 	= $this->layanan->select('layanan_id')->latest('layanan_id')->first();		
				createLog(config('tables.master.layanan'), 'INS', collect($saveLayanan)->sortKeys());	
				
				/**Unit Pelaksana Level 2 (Eselon 4) */
				$arrPelaksanaLevel2 	= '';
				foreach($request->pelaksana_level2 as $dataPelaksanaLevel2){
					$arrPelaksanaLevel2 = $arrPelaksanaLevel2.$dataPelaksanaLevel2['kojab'].";";
				}
				$arrPelaksanaLevel2 = substr($arrPelaksanaLevel2,0,-1);
				
				/**Unit Pendelegasian Kewenangan */
				$arrDelegasi 	= '';
				foreach($request->delagasi as $dataDelegasi){
					$arrDelegasi = $arrDelegasi.$dataDelegasi['opd_id'].";";
				}
				$arrDelegasi = substr($arrDelegasi,0,-1);
				
				/**Save tm_layanan_detail */
				$dataLayananDetil = ['layanan_id' 		=> $lastInsertedLayananId->layanan_id,
									'fungsi_layanan' 	=> $input['fungsi_layanan'], 
									'pelaksana_level1' 	=> $input['pelaksana_level1']['kojab'], 
									'pelaksana_level2' 	=> $arrPelaksanaLevel2, 
									'target_layanan' 	=> $input['target_layanan'], 
									'unit_delegasi' 	=> $arrDelegasi, 
									'created_by' 		=> $user_id
									];
							
				$saveLayananDetil		= $this->layananDetail->create($dataLayananDetil);		
				createLog(config('tables.master.layanan_detail'), 'INS', collect($saveLayananDetil)->sortKeys());	
				
				/**Save tm_layanan_proses */			
				$dataLDelLayananProses = ['deleted_by' => $user_id,
											'deleted_at' => date('Y-m-d H:i:s')
											];
				// DB::enableQueryLog();
				$this->layananProses
					 ->where('layanan_id', $lastInsertedLayananId->layanan_id)
					 ->update($dataLDelLayananProses);
				$probis 	= collect($request->prosesBisnis);
				$probis->each(function ($item, $key) use($lastInsertedLayananId, $user_id ) 
				{
					$where 			  = ['proses_id' => $item['proses_id'], 'layanan_id' => $lastInsertedLayananId->layanan_id];
					$cekLayananProses = $this->layananProses
											->where('proses_id', $item['proses_id'])
											->where('layanan_id', $lastInsertedLayananId->layanan_id)
											->get();
					if($cekLayananProses->count() > 0)
					{
						$dataLayDetilProses = ['deleted_by' => null,
											'deleted_at' => null
											];
						$del = $this->layananProses
									->where($where)
									->update($dataLayDetilProses);
						createLog(config('tables.master.layanan_proses'), 'DEL', collect($del)->sortKeys());
					}
					else
					{
						$dataLayDetilProses = ['layanan_id' => $lastInsertedLayananId->layanan_id,
											'proses_id' => $item['proses_id'],
											];
						$saveLayananDetilProses	= $this->layananProses
													->create($dataLayDetilProses);
						createLog(config('tables.master.layanan_proses'), 'INS', collect($saveLayananDetilProses)->sortKeys());
					}				
					
				});			
				
				$type 		= 'success';
				$errorMsg	= '';
				$message	= 'Data Tambah Domain Layanan Berhasil Disimpan';
			}catch(\Throwable $t){
				DB::rollBack();
				$type 		= 'error';
				$errorMsg 	= $t->getMessage();
				$message	= 'Data Tambah Domain Layanan Gagal Disimpan '.$errorMsg;
				$save 		= '';
			}
		}
		else
		{
			$errorMsg 	= '';
			$type 		= 'error';
			$message	= 'Layanan gagal disimpan. Nama layanan sudah terdaftar';
		}
					
		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}

	/**
	 * Get's a data proses bisnis
	 *
	 * @param int
	 * @return collection
	 */
	public function dataDomainLayanan(Request $request)
	{
		return $this->layanan->where('layanan_id',$request->id_layanan)
							->with([
								'layanan_proses' => function($q) {
									$q
									->join('tm_proses', 'tm_proses.proses_id', '=', 'tm_layanan_proses.proses_id')
									->join('tr_kode_kepmen', 'tr_kode_kepmen.kode_nomenklatur', '=', 'tm_proses.rab_level4')
									->where('tm_layanan_proses.deleted_at',null)
									->select('tm_layanan_proses.*','tr_kode_kepmen.nomenklatur_urusan as rab_level4', 'tm_proses.rab_level4 as kode_lev4');
								}
							])
							->first();
		// return $this->layanan->find($request->id_layanan);
	}

	/**
	 * Get's Layanan detail by layanan_id.
	 *
	 * @return mixed
	 */
	public function getLayananDetail(Request $request)
	{		
		// $layanan_id = $this->layanan->findBySlug($request->layanan_id);
		$query = $this->layananDetail
					  ->select(DB::raw('tm_layanan_detail.id idLayananDetail,
					  					tm_layanan_detail.fungsi_layanan, 
										tm_layanan_detail.pelaksana_level1, 
										tm_layanan_detail.pelaksana_level2, 
										tm_layanan_detail.target_layanan, 
										tm_layanan_detail.unit_delegasi,
										tm_layanan_detail.layanan_id'))
					  ->orderBy('tm_layanan_detail.layanan_id', 'desc')
					  ->where('tm_layanan_detail.deleted_at',null)
					  ->where('tm_layanan_detail.layanan_id', $request->layanan_id);
		
		if ($request->has('search') && strlen(trim($request->search)) > 0) {
			$mapped = $this->columnsDetail;
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
			$query->where('opd_id',$request->opd_id);
		}
		return $query->paginate($request->limit);
	}

	/**
	 * Get's a data layanan detail by id
	 *
	 * @param int
	 * @return collection
	 */
	public function getLayananDetailById(Request $request)
	{
		$query = $this->layananDetail->where('id', $request->id_layanan)->first();
		return $query;
	}
	
	/**
	 * Save Data Domain Layanan Detail.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function simpanLayananDetail($request){
		$input 		= $request->all();
		$user_id 	= auth()->user()->v_userid;
	
		try
		{			
			/**Unit Pelaksana Level 2 (Eselon 4) */
			$arrPelaksanaLevel2 	= '';
			foreach($request->pelaksana_level2 as $dataPelaksanaLevel2){
				$arrPelaksanaLevel2 = $arrPelaksanaLevel2.$dataPelaksanaLevel2['kojab'].";";
			}
			$arrPelaksanaLevel2 = substr($arrPelaksanaLevel2,0,-1);
			
			/**Unit Pendelegasian Kewenangan */
			$arrDelegasi 	= '';
			foreach($request->delagasi as $dataDelegasi){
				$arrDelegasi = $arrDelegasi.$dataDelegasi['opd_id'].";";
			}
			$arrDelegasi = substr($arrDelegasi,0,-1);
			
			/**Save tm_layanan_detail */
			$dataLayananDetil = ['layanan_id' => $input['layanan_id'],
								 'fungsi_layanan' => $input['fungsi_layanan'], 
								 'pelaksana_level1' => $input['pelaksana_level1']['kojab'], 
								 'pelaksana_level2' => $arrPelaksanaLevel2, 
								 'target_layanan' => $input['target_layanan'], 
								 'unit_delegasi' => $arrDelegasi, 
								 'created_by' => $user_id
								];
						
			$saveLayananDetil				= $this->layananDetail->create($dataLayananDetil);	
			$lastInsertedLayananDetilId 	= $this->layananDetail->select('id')->latest('id')->first();		
			createLog(config('tables.master.layanan_detail'), 'INS', collect($saveLayananDetil)->sortKeys());	
			
			$type 				= 'success';
			$errorMsg			= '';
			$message			= 'Data Tambah Domain Layanan Detail Berhasil Disimpan';

		}catch(\Throwable $t){
			DB::rollBack();
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Tambah Domain Layanan Detail Gagal Disimpan '.$errorMsg;
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}

		
	/**
	 * Save Data Domain Layanan Detail.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function ubahLayananDetail($request){
		$input 		= $request->all();
		$user_id 	= auth()->user()->v_userid;
	
		try
		{			
			/**Unit Pelaksana Level 2 (Eselon 4) */
			$arrPelaksanaLevel2 	= '';
			foreach($request->pelaksana_level2 as $dataPelaksanaLevel2){
				$arrPelaksanaLevel2 = $arrPelaksanaLevel2.$dataPelaksanaLevel2['kojab'].";";
			}
			$arrPelaksanaLevel2 = substr($arrPelaksanaLevel2,0,-1);
			
			/**Unit Pendelegasian Kewenangan */
			$arrDelegasi 	= '';
			foreach($request->delagasi as $dataDelegasi){
				$arrDelegasi = $arrDelegasi.$dataDelegasi['opd_id'].";";
			}
			$arrDelegasi = substr($arrDelegasi,0,-1);

			/**Save tm_layanan_detail */
			$dataLayananDetil = ['layanan_id' 		=> $input['layanan_id'],
								 'fungsi_layanan' 	=> $input['fungsi_layanan'], 
								 'pelaksana_level1' => $input['pelaksana_level1']['kojab'], 
								 'pelaksana_level2' => $arrPelaksanaLevel2, 
								 'target_layanan' 	=> $input['target_layanan'], 
								 'unit_delegasi' 	=> $arrDelegasi, 
								 'updated_by' 		=> $user_id
								];
						
			$saveLayananDetil = $this->layananDetail
									 ->where('id', $input['id_layanan_detail'])
									 ->update($dataLayananDetil);
			createLog(config('tables.master.layanan_detail'), 'UPD', collect($saveLayananDetil)->sortKeys());		
			
			/**Save tm_lay_detail_proses */			
			// $lastInsertedLayananDetilId 	= $this->layananDetail->select('id')->latest('id')->first();
			// $probis 	= collect($request->prosesBisnis);
			// $probis->each(function ($item, $key) use($input, $lastInsertedLayananDetilId, $user_id ) {
			// 	$dataLayDetilProses = ['layanan_detail_id' => $lastInsertedLayananDetilId->id,
			// 						   'proses_id' => $item['proses_id'],
			// 						  ];
			// 	$saveLayananDetilProses = $this->layananProses
			// 									->where('id',$input['layanan_id'])
			// 									->update($dataLayDetilProses);
			// 	createLog(config('tables.master.layanan_detail'), 'UPD', collect($saveLayananDetilProses)->sortKeys());
			// });			
			
			$type 				= 'success';
			$errorMsg			= '';
			$message			= 'Data Tambah Domain Layanan Detail Berhasil Disimpan';

		}catch(\Throwable $t){
			DB::rollBack();
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Tambah Domain Layanan Detail Gagal Disimpan '.$errorMsg;
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}
	
	public function deleteDataDomainLayananDetail($request)
	{
		try{			
			$user_id 	= auth()->user()->v_userid;

			/**tm_layanan_detail*/
			$data 		= ['deleted_by' => $user_id,
						   'deleted_at' => date('Y-m-d H:i:s')
						  ];
			
			$del = $this->layananDetail
						->where('id',$request->data['idlayanandetail'])
						->update($data);

			createLog(config('tables.master.layanan_detail'), 'DEL', collect($del)->sortKeys());
			
			/**tm_lay_detail_proses */
			// $dataLayDetailProses = ['deleted_by' => $user_id,
			// 						'deleted_at' => date('Y-m-d H:i:s')
			// 					   ];

			// $delLayDetailProses = $this->layananProses
			// 						   ->where('id',$request->data['idlaydetailproses'])
			// 						   ->update($dataLayDetailProses);

			// createLog(config('tables.master.layanan_proses'), 'DEL', collect($delLayDetailProses)->sortKeys());

			$type 				= 'success';
			$message			= 'Data Hapus Domain Layanan Detail Berhasil Dihapus	';
			$errorMsg			= '';
		}catch(\Throwable $t){
			$type 				= 'error';
			$message			= 'Data Hapus Domain Layanan Detail Gagal Dihapus ';
			$errorMsg 			= $t->getMessage();
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}

	/**
	 * Get's data view jabatan tropd eselon 3.
	 *
	 * @return mixed
	 */
	public function getJabatanTropdEselon3(Request $request)
	{		
		$query = $this->viewJabatanTropd
					  ->select(DB::raw('kojab, najabl, kojab_atasan'))
					  ->orderBy('kojab', 'asc')
					  ->orderBy('najabl', 'asc')
					  ->whereRaw('substr(eselon,0,1) = \'3\'')
					  ->where('opd_id',$request->opd_id);
		
		return $query->get();
	}

	/**
	 * Get's data view jabatan tropd eselon 4.
	 *
	 * @return mixed
	 */
	public function getJabatanTropdEselon4(Request $request)
	{		
		$query = $this->viewJabatanTropd
					  ->select(DB::raw('kojab, najabl, kojab_atasan'))
					  ->orderBy('kojab', 'asc')
					  ->orderBy('najabl', 'asc')
					  ->whereRaw('substr(eselon,0,1) = \'4\'')
					  ->where('kojab_atasan', $request->kojab_atasan)
					  ->where('opd_id', $request->opd_id);

		if(isset($request->kojab) and $request->kojab != ''){
			$query->whereIn('kojab',explode(';',$request->kojab));
		}
		
		return $query->get();
	}
}
