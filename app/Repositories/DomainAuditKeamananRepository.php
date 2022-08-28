<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\{DomainAuditKeamanan, DomainInfraNetDev};
use App\Repositories\Contracts\DomainAuditKeamananRepositoryInterface;

class DomainAuditKeamananRepository implements DomainAuditKeamananRepositoryInterface
{  
	protected $columns = [
        //'hierarchy_path',
        'nama_kegiatan' => 'nama_kegiatan',
        'hasil_audit' => 'hasil_audit',
        'id_metadata_terkait' => 'id_metadata_terkait',
        'jenis_audit' => 'jenis_audit',
        'tgl_kegiatan' => 'tgl_kegiatan',
        'tindak_lanjut' => 'tindak_lanjut',
        'rak_level_1' => 'rak_level_1',
        'rak_level_2' => 'rak_level_2'
	  ];

	/**
	 * DomainAuditKeamanan constructor
	 *
	 * @param DomainAuditKeamanan $domainAuditKeamanan
	 */
	public function __construct(
		DomainAuditKeamanan $domainAuditKeamanan,
		DomainInfraNetDev $domainInfraNetDev
		) 
	{
		$this->domainAuditKeamanan  = $domainAuditKeamanan;
		$this->domainInfraNetDev = $domainInfraNetDev;
	}

	/**
	 * Get's Domain Audit Keamanan
	 *
	 * @return mixed
	 */
	public function dataAuditKeamanan(Request $request)
	{		
		$query = $this->domainAuditKeamanan
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
	 * Save Data Domain Audit Keamanan.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainAuditKeamanan($request){
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
			
			$data = ['nama_kegiatan' => $input['nama'],
                    'hasil_audit' => $input['hasil']['kode'],
                    'jenis_audit' => $input['jenis']['kode'],
                    'tgl_kegiatan' => $input['tanggal'],
                    'tindak_lanjut' => $input['tl']['kode'],  
					/* 'rak_level_1' => $input['rai_level_1']['kode_nama'], 
					'rak_level_2' => $input['rai_level_2']['kode_nama'], */
					'rak_level_1' => $input['rai_level_1_fix'], 
					'rak_level_2' => $input['rai_level_2_fix'],
					'id_metadata_terkait' => $id_metadatas_final,
					'created_by' => $user_id,
					'created_at' => date('Y-m-d H:i:s')
					];
			$save 				= $this->domainAuditKeamanan->create($data);			
			createLog(config('tables.master.domain_audit_keamanan'), 'INS', collect($save)->sortKeys());

			$type 				= 'success';
			$errorMsg			= '';
			$message			= 'Data Domain Audit Keamanan Berhasil Disimpan';

		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Domain Audit Keamanan Gagal Disimpan '.$errorMsg;
			$save 				= '';
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}
	
	/**
	 * Save Update Data Domain Audit Keamanan .
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainAuditKeamanan( $request){
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

			$data = ['nama_kegiatan' => $input['nama'],
                    'hasil_audit' => $input['hasil']['kode'],
                    'jenis_audit' => $input['jenis']['kode'],
                    'tgl_kegiatan' => $input['tanggal'],
                    'tindak_lanjut' => $input['tl']['kode'],  
                    /* 'rak_level_1' => $input['rai_level_1']['kode_nama'], 
					'rak_level_2' => $input['rai_level_2']['kode_nama'], */
					'rak_level_1' => $input['rai_level_1_fix'], 
					'rak_level_2' => $input['rai_level_2_fix'],
					'id_metadata_terkait' => $id_metadatas_final,
					'updated_by' => $user_id,
					'updated_at' => date('Y-m-d H:i:s')
					];

			$post = $this->domainAuditKeamanan
						->where('id',$input['id'])
						->update($data);

			createLog(config('tables.master.domain_audit_keamanan'), 'UPD', collect($post)->sortKeys());

			$type 				= 'success';
			$errorMsg			= '';
			$message			= 'Data Domain Audit Keamanan Berhasil Diubah';
			DB::commit();
		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Domain Audit Keamanan Gagal Diubah '.$errorMsg;
			DB::rollBack();
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}

	/**
	 * Delete Data Domain Audit Keamanan.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainAuditKeamanan($request)
	{
		try{			
			$user_id 	= auth()->user()->v_userid;
			$data = ['is_active' => 0, 
					'deleted_by' => $user_id,
					'deleted_at' => date('Y-m-d H:i:s')
					];
			$del = $this->domainAuditKeamanan
						->where('id',$request->data['id'])
						->update($data);
			createLog(config('tables.master.domain_audit_keamanan'), 'DEL', collect($del)->sortKeys());

			$type 				= 'success';
			$message			= 'Data Domain Audit Keamanan Berhasil Dihapus	';
			$errorMsg			= '';
		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Domain Audit Keamanan Gagal Dihapus '.$errorMsg;
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}
	
	/**
	 * Get's a data domain Audit Keamanan
	 *
	 * @param int
	 * @return collection
	 */
	public function searchDomainAuditKeamanan(Request $request)
	{
		return $this->domainAuditKeamanan->findBySlug($request->id_audit);
        //return 'ini halaman search audit keamanan';
	}

	public function getMetadata(Request $request)
  	{
		$query = $this->domainInfraNetDev
		->select(DB::raw("domain_code as kode, nama as kode_nama"))
		->distinct("domain_code");

		return $query->get();
  	}
}
