<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\{DomainEdukasiKeamanan, TmAplikasi};

use App\Repositories\Contracts\DomainEdukasiKeamananRepositoryInterface;

class DomainEdukasiKeamananRepository implements DomainEdukasiKeamananRepositoryInterface
{  
	protected $columns = [
        'id' => 'id',
        'hierarchy_path' => 'hierarchy_path',
        'nama' => 'nama',
        'deskripsi' => 'deskripsi',
        'id_metadata_terkait' => 'id_metadata_terkait',
        'tgl_kegiatan' => 'tgl_kegiatan',
		'rak_level_1' => 'rak_level_1',
		'rak_level_2' => 'rak_level_2'
	  ];

	/**
	 * DomainEdukasiKeamanan constructor
	 *
	 * @param DomainEdukasiKeamanan $domainEdukasiKeamanan
	 */
	public function __construct(
		DomainEdukasiKeamanan $domainEdukasiKeamanan,
		TmAplikasi $tmAplikasi
		) 
	{
		$this->domainEdukasiKeamanan  = $domainEdukasiKeamanan;
		$this->tmAplikasi = $tmAplikasi;
	}

	/**
	 * Get's Domain Edukasi Keamanan
	 *
	 * @return mixed
	 */
	public function dataEdukasiKeamanan(Request $request)
	{		
		$query = $this->domainEdukasiKeamanan
					  ->orderBy('id', 'desc')
					  ->where(DB::raw('nvl(to_number(is_active),1)'), '<>', 0);

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
		return $query->paginate($request->limit);
	}

	
	/**
	 * Save Data Domain Edukasi Keamanan.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainEdukasiKeamanan($request){
		$input 		= $request->all();
		$user_id 	= auth()->user()->v_userid;
		try
		{
			$id_metadatas_final = "";
			foreach ($request->id_metadata_terkait as $key => $value) {
				if($key != array_key_last($request->id_metadata_terkait)){
				  $id_metadata = $value['kode'];
				  $id_metadatas = $id_metadata . "; ";
				  $id_metadatas_final = $id_metadatas_final . $id_metadatas;
				}else{
				  $id_metadata = $value['kode'];
				  $id_metadatas = $id_metadata;
				  $id_metadatas_final = $id_metadatas_final . $id_metadatas;
				}
			}
			
			$data = ['nama' => $input['nama'],
                    'deskripsi' => $input['deskripsi'],
                    'tgl_kegiatan' => $input['tanggal'],  
					/* 'rak_level_1' => $input['rai_level_1']['kode_nama'], 
					'rak_level_2' => $input['rai_level_2']['kode_nama'], */
					'rak_level_1' => $input['rai_level_1_fix'],
					'rak_level_2' => $input['rai_level_2_fix'],
					'id_metadata_terkait' => $id_metadatas_final,
					'created_at' => date('Y-m-d H:i:s'),
					'created_by' => $user_id
					];
			
			//dd($data);
			///*
			$save 				= $this->domainEdukasiKeamanan->create($data);			
			createLog(config('tables.master.domain_edukasi_keamanan'), 'INS', collect($save)->sortKeys());

			$type 				= 'success';
			$errorMsg			= '';
			$message			= 'Data Domain Edukasi Keamanan Berhasil Disimpan';

		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Domain Edukasi Keamanan Gagal Disimpan '.$errorMsg;
			$save 				= '';
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
		//*/
	}
	
	/**
	 * Save Update Data Domain Edukasi Keamanan .
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainEdukasiKeamanan( $request){
		$input 		= $request->all();
		$user_id 	= auth()->user()->v_userid;

		DB::beginTransaction();
		try
		{
			$id_metadatas_final = "";
			foreach ($request->id_metadata_terkait as $key => $value) {
				if($key != array_key_last($request->id_metadata_terkait)){
				  $id_metadata = $value['kode'];
				  $id_metadatas = $id_metadata . "; ";
				  $id_metadatas_final = $id_metadatas_final . $id_metadatas;
				}else{
				  $id_metadata = $value['kode'];
				  $id_metadatas = $id_metadata;
				  $id_metadatas_final = $id_metadatas_final . $id_metadatas;
				}
			}

			$data = ['nama' => $input['nama'],
                    'deskripsi' => $input['deskripsi'],
                    'tgl_kegiatan' => $input['tanggal'],  
                    /* 'rak_level_1' => $input['rai_level_1']['kode_nama'], 
                    'rak_level_2' => $input['rai_level_2']['kode_nama'], */
					'rak_level_1' => $input['rai_level_1_fix'],
					'rak_level_2' => $input['rai_level_2_fix'],
					'id_metadata_terkait' => $id_metadatas_final,
					'updated_by' => $user_id,
					'updated_at' => date('Y-m-d H:i:s')
					];

			$post = $this->domainEdukasiKeamanan
						->where('id',$input['id'])
						->update($data);

			createLog(config('tables.master.domain_edukasi_keamanan'), 'UPD', collect($post)->sortKeys());

			$type 				= 'success';
			$errorMsg			= '';
			$message			= 'Data Domain Edukasi Keamanan Berhasil Diubah';
			DB::commit();
		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Domain Edukasi Keamanan Gagal Diubah '.$errorMsg;
			DB::rollBack();
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}

	/**
	 * Delete Data Domain Edukasi Keamanan.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainEdukasiKeamanan($request)
	{
		try{			
			$user_id 	= auth()->user()->v_userid;
			$data = ['is_active' => 0, 
					'deleted_by' => $user_id,
					'deleted_at' => date('Y-m-d H:i:s')
					];
			$del = $this->domainEdukasiKeamanan
						->where('id',$request->data['id'])
						->update($data);
			createLog(config('tables.master.domain_edukasi_keamanan'), 'DEL', collect($del)->sortKeys());

			$type 				= 'success';
			$message			= 'Data Domain Edukasi Keamanan Berhasil Dihapus	';
			$errorMsg			= '';
		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Domain Edukasi Keamanan Gagal Dihapus '.$errorMsg;
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}
	
	/**
	 * Get's a data domain Edukasi Keamanan
	 *
	 * @param int
	 * @return collection
	 */
	public function searchDomainEdukasiKeamanan(Request $request)
	{
		return $this->domainEdukasiKeamanan->findBySlug($request->id_edukasi);
	}

	public function getMetadata(Request $request)
  	{
		$query = $this->tmAplikasi
		->select(DB::raw("apl_id as kode, nama_apl as kode_nama"))
		->distinct("apl_id");

		return $query->get();
  	}
}
