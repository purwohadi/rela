<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\DomainInfraServer;
use App\Http\Resources\Domain\DomainInfraServerResources;
use App\Repositories\Contracts\DomainInfraServerRepositoryInterface;

class DomainInfraServerRepository implements DomainInfraServerRepositoryInterface
{  
	protected $columns = [
		'opd_id' => 'opd_id',
		'rai_level1' => 'rai_level_1',
		'rai_level2' => 'rai_level_2',
		'rai_level3' => 'rai_level_3',
		'rai_level4' => 'rai_level_4',
		'instansi' => 'instansi',
		'nama' => 'nama',
		'domain_code' => 'domain_code',
		'id_metadata_terkait' => 'id_metadata_terkait',
		'id' => 'id',
	];

	/**
	 * DomainInfraServer constructor
	 *
	 * @param DomainInfraServer $domainInfraServer
	 */
	public function __construct(DomainInfraServer $domainInfraServer) 
	{
		$this->domainInfraServer  = $domainInfraServer;
	}

	public function listData(Request $request)
	{		
		$query = $this->domainInfraServer
			//->where(DB::raw('nvl(to_number(is_active),1)'), '<>', 0)
			//->orderBy('id', 'desc');
			
			//change
			->orderBy('id', 'desc')
			->where('deleted_by', null)
			->where('opd_id',$request->opd_id);
		
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
		/*
		if(isset($request->opd_id)){
			$query->where('opd_id',$request->opd_id);
		}
		*/
		return $query->paginate($request->limit);
		//return DomainInfraServerResources::collection($query->paginate($request->limit));
	}

	public function delete($request)
	{
		try{
			$user_id = auth()->user()->v_userid;
			$data = ['is_active' => 0, 
					 'deleted_by' => $user_id,
					 'deleted_at' => date('Y-m-d H:i:s')
					];
			$del = $this->domainInfraServer
						->where('id', $request->id)
						->update($data);
			createLog(config('tables.master.domain_infra_server'), 'DEL', collect($del)->sortKeys());

			$type 				= 'success';
			$message			= 'Data Domain Infra Server Berhasil Dihapus	';
			$errorMsg			= '';
		}catch(\Throwable $t){
			$type 				= 'error';
			$message			= 'Data Domain Infra Server Gagal Dihapus ';
			$errorMsg 			= $t->getMessage();
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}

	public function update(Request $request){
		$input 		= $request->all();
		$user_id 	= auth()->user()->v_userid;
		$before = $this->domainInfraServer->findBySlug($input['id']);
		DB::beginTransaction();
		try
		{
			$kode_l01 = substr(explode(" ", $input['rai_level_1'])[0], 4);
			$kode_l02 = substr(explode(" ", $input['rai_level_2'])[0], 4);
			$kode_l03 = substr(explode(" ", $input['rai_level_3'])[0], 4);
			$kode_l04 = explode(" ", $input['rai_level_4'])[0];
			
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

			$software_used_final = "";
			foreach ($request->software_used as $key => $value) {
				if($key != array_key_last($request->software_used)){
				  $id_software_used = $value['kode_nama'];
				  $id_software_used_b = $id_software_used . "; ";
				  $software_used_final = $software_used_final . $id_software_used_b;
				}else{
				  $id_software_used = $value['kode_nama'];
				  $id_software_used_b = $id_software_used;
				  $software_used_final = $software_used_final . $id_software_used_b;
				}
			}

			$data = ['nama' => $input['nama'], 
					 /*
					 'rai_level_1' => $input['rai_level_1'], 
					 'rai_level_2' => $input['rai_level_2'], 
					 'rai_level_3' => $input['rai_level_3'],
					 'rai_level_4' => $input['rai_level_4'], 
					 */
					'rai_level_1' => $input['rai_level_1_fix'], 
					'rai_level_2' => $input['rai_level_2_fix'], 
					'rai_level_3' => $input['rai_level_3_fix'],
					'rai_level_4' => $input['rai_level_4'],
					 'opd_id' => $input['opd_id'],
					 'instansi' => $input['instansi'], 
					 'deskripsi' => $input['deskripsi'], 
					 'jenis_penggunaan' => $input['jenis_penggunaan']['kode_nama'], 
					 'nama_owner' => $input['nama_owner'], 
					 'status_ownership' => $input['status_ownership']['kode_nama'], 					
					 'unit_pengelola' => $input['unit_pengelola'], 
					 'lokasi' => $input['lokasi'], 
					 'software_used' => $software_used_final,
					 'kapasitas_memori' => $input['kapasitas_memori'],
					 'kapasitas_penyimpanan' => $input['kapasitas_penyimpanan'],
					 'kode_referensi_infra' => $input['kode_referensi_infra'],
					 'teknik_penyimpanan' => $input['teknik_penyimpanan']['kode_nama'],
					 'jenis_prosesor' => $input['jenis_prosesor'],
					 'id_metadata_terkait' => $id_metadatas_final,  
					 /*
					 'kode_l01' => $kode_l01,
					 'kode_l02' => $kode_l02,
					 'kode_l03' => $kode_l03,
					 'kode_l04' => $kode_l04,
					 'domain_code' => 'DAI ' . $kode_l04,
					 */
					 'updated_by' => $user_id,
					 'updated_at' => date('Y-m-d H:i:s')
					];
			$updateData = $this->domainInfraServer->find($input['id']);
			$updateData->update($data);

			$save = $updateData;
			createLog(config('tables.master.domain_infra_server'), 'UPD', [
				'before' => collect($before)->sortKeys(),
				'after' => collect($updateData)->sortKeys()
			]);

			$type 				= 'success';
			$errorMsg			= '';
			$message			= 'Data Berhasil Disimpan.';
			DB::commit();
		}catch(\Throwable $t){
			$type 				= 'error';
			$save 				= $t->getMessage();
			$message			= 'Data Gagal Disimpan.';
			DB::rollBack();
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'save' => $save
				 ];
		return json_encode($hasil);
	}

	
	public function save($request){
		$input 		= $request->all();
		$user_id 	= auth()->user()->v_userid;
		try
		{			
			$kode_l01 = explode(" ", $input['rai_level_1_fix'])[0];
			$kode_l02 = explode(" ", $input['rai_level_2_fix'])[0];
			$kode_l03 = explode(" ", $input['rai_level_3_fix'])[0];
			$kode_l04 = explode(" ", $input['rai_level_4'])[0];

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

			$software_used_final = "";
			foreach ($request->software_used as $key => $value) {
				if($key != array_key_last($request->software_used)){
				  $id_software_used = $value['kode_nama'];
				  $id_software_used_b = $id_software_used . "; ";
				  $software_used_final = $software_used_final . $id_software_used_b;
				}else{
				  $id_software_used = $value['kode_nama'];
				  $id_software_used_b = $id_software_used;
				  $software_used_final = $software_used_final . $id_software_used_b;
				}
			}

			$data = ['nama' => $input['nama'], 
					/*
					'rai_level_1' => $input['rai_level_1'], 
					'rai_level_2' => $input['rai_level_2'], 
					'rai_level_3' => $input['rai_level_3'],
					'rai_level_4' => $input['rai_level_4'], 
					*/
					'rai_level_1' => $input['rai_level_1_fix'], 
					'rai_level_2' => $input['rai_level_2_fix'], 
					'rai_level_3' => $input['rai_level_3_fix'],
					'rai_level_4' => $input['rai_level_4'],
					'opd_id' => $input['opd_id'],
					'instansi' => $input['instansi'],
					'deskripsi' => $input['deskripsi'], 
					'jenis_penggunaan' => $input['jenis_penggunaan']['kode_nama'], 
					'nama_owner' => $input['nama_owner'], 
					'status_ownership' => $input['status_ownership']['kode_nama'], 					
					'unit_pengelola' => $input['unit_pengelola'], 
					'lokasi' => $input['lokasi'], 
					'software_used' => $software_used_final,
					'kapasitas_memori' => $input['kapasitas_memori'],
					'kapasitas_penyimpanan' => $input['kapasitas_penyimpanan'],
					'kode_referensi_infra' => $input['kode_referensi_infra'],
					'teknik_penyimpanan' => $input['teknik_penyimpanan']['kode_nama'],
					'jenis_prosesor' => $input['jenis_prosesor'], 
					'id_metadata_terkait' => $id_metadatas_final,  
					'kode_l01' => $kode_l01,
					'kode_l02' => $kode_l02,
					'kode_l03' => $kode_l03,
					'kode_l04' => $kode_l04,
					'domain_code' => 'DAI ' . $kode_l04,
					'created_by' => $user_id,
					'created_at' => date('Y-m-d H:i:s')
					];

			$save = $this->domainInfraServer->create($data);
			createLog(config('tables.master.domain_infra_server'), 'INS', collect($save)->sortKeys());

			$type 				= 'success';
			$message			= 'Data Domain Infra Server Berhasil Disimpan';

		}catch(\Throwable $t){
			$type 				= 'error';
			$save 				= $t->getMessage();
			$message			= 'Data Domain Infra Server Gagal Disimpan';
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'save' => $save
				 ];
		return json_encode($hasil);
	}

	
	public function show($id)
	{
		return $this->domainInfraServer->findBySlug($id);
	}

	
	
	public function getDataBy(Request $request)
	{
		$query = $this->domainInfraServer
					  ->select(DB::raw(''.$request->col.' as kode, '.$request->col.' as kode_nama'))
					  ->groupBy($request->col);
		return $query->get();
	}
}
