<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\{DomainStandarKeamanan, TmAplikasi};
use App\Repositories\Contracts\DomainStandarKeamananRepositoryInterface;

class DomainStandarKeamananRepository implements DomainStandarKeamananRepositoryInterface
{  
	protected $columns = [
		'nama' => 'nama',
		'id_metadata_terkait' => 'id_metadata_terkait',
		'tgl_mulai' => 'tgl_mulai'
	  ];

	/**
	 * DomainStandarKeamananRepository constructor
	 *
	 * @param DomainStandarKeamanan $domainStandarKeamanan
	 */
	public function __construct(
		DomainStandarKeamanan $domainStandarKeamanan,
		TmAplikasi $tmAplikasi
		) 
	{
		$this->domainStandarKeamanan  = $domainStandarKeamanan;
		$this->tmAplikasi = $tmAplikasi;
	}

	/**
	 * Get's Domain Standar Keamanan
	 *
	 * @return mixed
	 */
	public function dataStandarTeknisKeamanan(Request $request)
	{		
		$query = $this->domainStandarKeamanan
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
	 * Save Data Domain Standar Keamanan.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainStandarKeamanan($request){
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
					 'tgl_mulai' => $input['tgl_mulai'],
					 'rak_level_1' => $input['rai_level_1_fix'],
					 'rak_level_2' => $input['rai_level_2']['kode_nama'], 
					 //'id_metadata_terkait' => $input['id_metadata_terkait']['kode'],
					 'id_metadata_terkait' => $id_metadatas_final, 
					 'created_by' => $user_id,
					 'created_at' => date('Y-m-d H:i:s')
					];
			$save 				= $this->domainStandarKeamanan->create($data);			
			createLog(config('tables.master.domain_standar_keamanan'), 'INS', collect($save)->sortKeys());

			$type 				= 'success';
			$errorMsg			= '';
			$message			= 'Data Tambah Domain Standar Keamanan Berhasil Disimpan';

		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Tambah Domain Standar Keamanan Gagal Disimpan '.$errorMsg;
			$save 				= '';
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}
	
	/**
	 * Save Update Data Domain Standar Keamanan .
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainStandarKeamanan( $request){
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
					 'tgl_mulai' => $input['tgl_mulai'],
					 'rak_level_1' => $input['rai_level_1_fix'],
					 'rak_level_2' => $input['rai_level_2']['kode_nama'],  
					 //'id_metadata_terkait' => $input['id_metadata_terkait']['kode'],
					 'id_metadata_terkait' => $id_metadatas_final, 
					 'updated_by' => $user_id,
					 'updated_at' => date('Y-m-d H:i:s')
					];

			$post = $this->domainStandarKeamanan
						->where('id',$input['id'])
						->update($data);

			createLog(config('tables.master.domain_standar_keamanan'), 'UPD', collect($post)->sortKeys());

			$type 				= 'success';
			$errorMsg			= '';
			$message			= 'Data Domain Standar Keamanan Berhasil Diubah';
			DB::commit();
		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Domain Standar Keamanan Gagal Diubah '.$errorMsg;
			DB::rollBack();
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}

	/**
	 * Delete Data Domain Standar Keamanan.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainStandarKeamanan($request)
	{
		try{			
			$user_id = auth()->user()->v_userid;
			$data 	 = ['is_active' => 0, 
						'deleted_by' => $user_id,
						'deleted_at' => date('Y-m-d H:i:s')
					   ];
			$del 	 = $this->domainStandarKeamanan
							->where('id',$request->data['id'])
							->update($data);
			createLog(config('tables.master.domain_standar_keamanan'), 'DEL', collect($del)->sortKeys());

			$type 				= 'success';
			$message			= 'Data Domain Standar Keamanan Berhasil Dihapus	';
			$errorMsg			= '';
		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Domain Standar Keamanan Gagal Dihapus '.$errorMsg;
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}
	
	/**
	 * Get's a data domain standar keamanan
	 *
	 * @param int
	 * @return collection
	 */
	public function searchStandarKeamanan(Request $request)
	{
		return $this->domainStandarKeamanan->findBySlug($request->id_sk);
	}

	public function getMetadata(Request $request)
  	{

    $query = $this->tmAplikasi
      ->select(DB::raw("apl_id as kode, nama_apl as kode_nama"))
      ->distinct("apl_id");

    return $query->get();
  	}

	  public function searchNamaAplikasi(Request $request)
	  {
		$query = $this->tmAplikasi
					->select(DB::raw("apl_id as kode, nama_apl as kode_nama"))
					->where('apl_id', $request->id_aplikasi);

		  return $query->get();
	  }
}
