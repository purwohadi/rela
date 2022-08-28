<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\{DomainPeningkatanKeamanan, TmAplikasi, DomainInfraNetDev};
use App\Repositories\Contracts\DomainPeningkatanKeamananRepositoryInterface;

class DomainPeningkatanKeamananRepository implements DomainPeningkatanKeamananRepositoryInterface
{  
	protected $columns = [
        //'id' => 'id',
        //'hierarchy_path' => 'hierarchy_path',
        'nama_kegiatan' => 'nama_kegiatan',
        'deskripsi' => 'deskripsi',
        //'id_metadata_terkait' => 'id_metadata_terkait',
        'tgl_kegiatan' => 'tgl_kegiatan',
		'rak_level_1' => 'rak_level_1',
		'rak_level_2' => 'rak_level_2'
	  ];

	/**
	 * DomainPeningkatanKeamanan constructor
	 *
	 * @param DomainPeningkatanKeamanan $domainPeningkatanKeamanan
	 */
	public function __construct(
		DomainPeningkatanKeamanan $domainPeningkatanKeamanan,
		DomainInfraNetDev $domainInfraNetDev,
		TmAplikasi $tmAplikasi
		) 
	{
		$this->domainPeningkatanKeamanan  = $domainPeningkatanKeamanan;
		$this->domainInfraNetDev = $domainInfraNetDev;
		$this->tmAplikasi = $tmAplikasi;
	}

	/**
	 * Get's Domain Peningkatan Keamanan
	 *
	 * @return mixed
	 */
	public function dataPeningkatanKeamanan(Request $request)
	{		
		$query = $this->domainPeningkatanKeamanan
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
	 * Save Data Domain Peningkatan Keamanan.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainPeningkatanKeamanan($request){
		$input 		= $request->all();
		$user_id 	= auth()->user()->v_userid;
		try
		{
			$id_metadatas_final_app = "";
			foreach ($request->id_metadata_terkait_app as $key => $value) {
				if($key != array_key_last($request->id_metadata_terkait_app)){
				  $id_metadata = $value['kode'];
				  $id_metadatas = $id_metadata . "; ";
				  $id_metadatas_final_app = $id_metadatas_final_app . $id_metadatas;
				}else{
				  $id_metadata = $value['kode'];
				  $id_metadatas = $id_metadata;
				  $id_metadatas_final_app = $id_metadatas_final_app . $id_metadatas;
				}
			}

			$id_metadatas_final_netdev = "";
			foreach ($request->id_metadata_terkait_netdev as $key => $value) {
				if($key != array_key_last($request->id_metadata_terkait_netdev)){
				  $id_metadata_netdev = $value['kode'];
				  $id_metadatas_netdev = $id_metadata_netdev . "; ";
				  $id_metadatas_final_netdev = $id_metadatas_final_netdev . $id_metadatas_netdev;
				}else{
				  $id_metadata_netdev = $value['kode'];
				  $id_metadatas_netdev = $id_metadata_netdev;
				  $id_metadatas_final_netdev = $id_metadatas_final_netdev . $id_metadatas_netdev;
				}
			}

			$data = ['nama_kegiatan' => $input['nama'],
                    'deskripsi' => $input['deskripsi'],
                    'tgl_kegiatan' => $input['tanggal'],  
					/* 'rak_level_1' => $input['rai_level_1']['kode_nama'], 
                    'rak_level_2' => $input['rai_level_2']['kode_nama'], */
					'rak_level_1' => $input['rai_level_1_fix'],
					'rak_level_2' => $input['rai_level_2_fix'],
					'id_metadata_terkait_app' => $id_metadatas_final_app,
					'id_metadata_terkait_netdev' => $id_metadatas_final_netdev,
					'created_by' => $user_id,
					'created_at' => date('Y-m-d H:i:s')
					];
			$save 				= $this->domainPeningkatanKeamanan->create($data);			
			createLog(config('tables.master.domain_peningkatan_keamanan'), 'INS', collect($save)->sortKeys());

			$type 				= 'success';
			$errorMsg			= '';
			$message			= 'Data Domain Peningkatan Keamanan Berhasil Disimpan';

		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Domain Peningkatan Keamanan Gagal Disimpan '.$errorMsg;
			$save 				= '';
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}
	
	/**
	 * Save Update Data Domain Peningkatan Keamanan .
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainPeningkatanKeamanan( $request){
		$input 		= $request->all();
		$user_id 	= auth()->user()->v_userid;

		DB::beginTransaction();
		try
		{
			$id_metadatas_final_app = "";
			foreach ($request->id_metadata_terkait_app as $key => $value) {
				if($key != array_key_last($request->id_metadata_terkait_app)){
				  $id_metadata = $value['kode'];
				  $id_metadatas = $id_metadata . "; ";
				  $id_metadatas_final_app = $id_metadatas_final_app . $id_metadatas;
				}else{
				  $id_metadata = $value['kode'];
				  $id_metadatas = $id_metadata;
				  $id_metadatas_final_app = $id_metadatas_final_app . $id_metadatas;
				}
			}

			$id_metadatas_final_netdev = "";
			foreach ($request->id_metadata_terkait_netdev as $key => $value) {
				if($key != array_key_last($request->id_metadata_terkait_netdev)){
				  $id_metadata_netdev = $value['kode'];
				  $id_metadatas_netdev = $id_metadata_netdev . "; ";
				  $id_metadatas_final_netdev = $id_metadatas_final_netdev . $id_metadatas_netdev;
				}else{
				  $id_metadata_netdev = $value['kode'];
				  $id_metadatas_netdev = $id_metadata_netdev;
				  $id_metadatas_final_netdev = $id_metadatas_final_netdev . $id_metadatas_netdev;
				}
			}

			$data = ['nama_kegiatan' => $input['nama'],
                    'deskripsi' => $input['deskripsi'],
                    'tgl_kegiatan' => $input['tanggal'],  
                    /* 'rak_level_1' => $input['rai_level_1']['kode_nama'], 
                    'rak_level_2' => $input['rai_level_2']['kode_nama'], */
					'rak_level_1' => $input['rai_level_1_fix'],
					'rak_level_2' => $input['rai_level_2_fix'],
					'id_metadata_terkait_app' => $id_metadatas_final_app,
					'id_metadata_terkait_netdev' => $id_metadatas_final_netdev,
					'updated_by' => $user_id,
					'updated_at' => date('Y-m-d H:i:s')
					];

			$post = $this->domainPeningkatanKeamanan
						->where('id',$input['id'])
						->update($data);

			createLog(config('tables.master.domain_peningkatan_keamanan'), 'UPD', collect($post)->sortKeys());

			$type 				= 'success';
			$errorMsg			= '';
			$message			= 'Data Domain Peningkatan Keamanan Berhasil Diubah';
			DB::commit();
		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Domain Peningkatan Keamanan Gagal Diubah '.$errorMsg;
			DB::rollBack();
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}

	/**
	 * Delete Data Domain Peningkatan Keamanan.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainPeningkatanKeamanan($request)
	{
		try{			
			$user_id 	= auth()->user()->v_userid;
			$data = ['is_active' => 0, 
					'deleted_by' => $user_id,
					'deleted_at' => date('Y-m-d H:i:s')
					];
			$del = $this->domainPeningkatanKeamanan
						->where('id',$request->data['id'])
						->update($data);
			createLog(config('tables.master.domain_peningkatan_keamanan'), 'DEL', collect($del)->sortKeys());

			$type 				= 'success';
			$message			= 'Data Domain Peningkatan Keamanan Berhasil Dihapus	';
			$errorMsg			= '';
		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Domain Peningkatan Keamanan Gagal Dihapus '.$errorMsg;
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}
	
	/**
	 * Get's a data domain Peningkatan Keamanan
	 *
	 * @param int
	 * @return collection
	 */
	public function searchDomainPeningkatanKeamanan(Request $request)
	{
		return $this->domainPeningkatanKeamanan->findBySlug($request->id_peningkatan);
	}

	public function getMetadataApp(Request $request)
  	{
		$query = $this->tmAplikasi
		->select(DB::raw("apl_id as kode, nama_apl as kode_nama"))
		->distinct("apl_id");

		return $query->get();
  	}

	public function getMetadataNetdev(Request $request)
  	{
		$query = $this->domainInfraNetDev
		->select(DB::raw("domain_code as kode, nama as kode_nama"))
		->distinct("domain_code");

		return $query->get();
  	}
}
