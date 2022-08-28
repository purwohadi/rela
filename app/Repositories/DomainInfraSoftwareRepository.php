<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\{DomainInfraSoftware, TmInfrastrukturSplp, TmInfraKeamanan};
use App\Http\Resources\Domain\DomainInfraSoftwareResources;
use App\Repositories\Contracts\DomainInfraSoftwareRepositoryInterface;

class DomainInfraSoftwareRepository implements DomainInfraSoftwareRepositoryInterface
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
   * DomainInfraSoftware constructor
   *
   * @param DomainInfraSoftware $domainInfraSoftware
   * @param TmInfrastrukturSplp $TmInfrastrukturSplp
   * @param TmInfraKeamanan $TmInfraKeamanan
   */
	public function __construct(DomainInfraSoftware $domainInfraSoftware, TmInfrastrukturSplp $TmInfrastrukturSplp, TmInfraKeamanan $TmInfraKeamanan)
	{
		$this->domainInfraSoftware  = $domainInfraSoftware;
		$this->TmInfrastrukturSplp  = $TmInfrastrukturSplp;
		$this->TmInfraKeamanan  = $TmInfraKeamanan;
	}

	public function listData(Request $request)
	{
		$query = $this->domainInfraSoftware
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
		//return DomainInfraSoftwareResources::collection($query->paginate($request->limit));
	}

	public function delete($request, $id)
	{
		try{
			$user_id = auth()->user()->v_userid;
			$data = ['is_active' => 0,
					'deleted_by' => $user_id,
					'deleted_at' => date('Y-m-d H:i:s')
					];
			$del = $this->domainInfraSoftware
				->where('id', $id)
				->update($data);
			createLog(config('tables.master.domain_infra_software'), 'DEL', collect($del)->sortKeys());

			$type 				= 'success';
			$message			= 'Data Domain Infra Software Berhasil Dihapus	';
			$errorMsg			= '';
		}catch(\Throwable $t){
			$type 				= 'error';
			$message			= 'Data Domain Infra Software Gagal Dihapus ';
			$errorMsg 			= $t->getMessage();
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}

	public function update(Request $request, $id){
		$input 		= $request->all();
		$user_id 	= auth()->user()->v_userid;

		$before = $this->domainInfraSoftware->findBySlug($id);
		DB::beginTransaction();
		try
		{
			/*
			$kode_l01 = substr(explode(" ", $input['rai_level_1'])[0], 4);
			$kode_l02 = substr(explode(" ", $input['rai_level_2'])[0], 4);
			$kode_l03 = substr(explode(" ", $input['rai_level_3'])[0], 4);
			$kode_l04 = explode(" ", $input['rai_level_4'])[0];
			*/

			$kode_l01 = substr(explode(" ", $input['rai_level_1_fix'])[0], 4);
			$kode_l02 = substr(explode(" ", $input['rai_level_2_fix'])[0], 4);
			$kode_l03 = substr(explode(" ", $input['rai_level_3_fix'])[0], 4);
			$kode_l04 = explode(" ", $input['rai_level_4'])[0];
			
			$id_metadatas_final = "";
			foreach ($request->id_metadata_terkait as $key => $value) {
				if($key != array_key_last($request->id_metadata_terkait)){
				  $id_metadata = $value['value'];
				  $id_metadatas = $id_metadata . "; ";
				  $id_metadatas_final = $id_metadatas_final . $id_metadatas;
				}else{
				  $id_metadata = $value['value'];
				  $id_metadatas = $id_metadata;
				  $id_metadatas_final = $id_metadatas_final . $id_metadatas;
				}
			}

			if(!empty($input['nama_sistem_db']['kode_nama'])){
				$nama_db = $input['nama_sistem_db']['kode_nama'];
			}else{
				$nama_db = '-';
			}

			if(!empty($input['nama_os']['kode_nama'])){
				$nama_os = $input['nama_os']['kode_nama'];
			}else{
				$nama_os = '-';
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
					//'nama_os' => $input['nama_os']['kode_nama'],
					'nama_os' => $nama_os, 
					'nama_sistem_utilitas' => $input['nama_sistem_utilitas'], 
					//'nama_sistem_db' => $input['nama_sistem_db']['kode_nama'],
					'nama_sistem_db' => $nama_db, 					
					'jenis_lisensi' => $input['jenis_lisensi']['kode_nama'], 
					'owner_lisensi' => $input['owner_lisensi'], 
					'validitas_lisensi' => $input['validitas_lisensi'], 
					//'id_metadata_terkait' => $input['id_metadata_terkait'], 
					'kode_l01' => $kode_l01,
					'kode_l02' => $kode_l02,
					'kode_l03' => $kode_l03,
					'kode_l04' => $kode_l04,
					//'id_metadata_terkait' => $input['id_metadata_terkait']['value'],
					'id_metadata_terkait' => $id_metadatas_final, 
					'domain_code' => 'DAI ' . $kode_l04,
					'updated_by' => $user_id,
					'updated_at' => date('Y-m-d H:i:s')
					];


			$updateData = $this->domainInfraSoftware->find($input['id']);
			$updateData->update($data);

			$save = $updateData;
			createLog(config('tables.master.domain_infra_software'), 'UPD', [
				'before' => collect($before)->sortKeys(),
				'after' => collect($updateData)->sortKeys()
			]);

			/*
			$post = $this->domainInfraSoftware
						->where('id', $input['id'])
						->update($data);

			createLog(config('tables.master.domain_infra_software'), 'UPD', collect($post)->sortKeys());
			*/

			$type 				= 'success';
			$errorMsg			= '';
			$message			= 'Data Berhasil Disimpan.';
			DB::commit();
		}catch(\Throwable $t){
			$type 				= 'error';
			$save 				= $t->getMessage();
			$message			= 'Data Gagal Disimpan.'.$save;
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
			/*
			$kode_l01 = substr(explode(" ", $input['rai_level_1'])[0], 4);
			$kode_l02 = substr(explode(" ", $input['rai_level_2'])[0], 4);
			$kode_l03 = substr(explode(" ", $input['rai_level_3'])[0], 4);
			$kode_l04 = explode(" ", $input['rai_level_4'])[0];
			*/

			$kode_l01 = explode(" ", $input['rai_level_1_fix'])[0];
			$kode_l02 = explode(" ", $input['rai_level_2_fix'])[0];
			$kode_l03 = explode(" ", $input['rai_level_3_fix'])[0];
			$kode_l04 = explode(" ", $input['rai_level_4'])[0];
			
			$id_metadatas_final = "";
			foreach ($request->id_metadata_terkait as $key => $value) {
				if($key != array_key_last($request->id_metadata_terkait)){
				  $id_metadata = $value['value'];
				  $id_metadatas = $id_metadata . "; ";
				  $id_metadatas_final = $id_metadatas_final . $id_metadatas;
				}else{
				  $id_metadata = $value['value'];
				  $id_metadatas = $id_metadata;
				  $id_metadatas_final = $id_metadatas_final . $id_metadatas;
				}
			}

			if(!empty($input['nama_sistem_db']['kode_nama'])){
				$nama_db = $input['nama_sistem_db']['kode_nama'];
			}else{
				$nama_db = '-';
			}

			if(!empty($input['nama_os']['kode_nama'])){
				$nama_os = $input['nama_os']['kode_nama'];
			}else{
				$nama_os = '-';
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
					//'nama_os' => $input['nama_os']['kode_nama'],
					'nama_os' => $nama_os,
					'nama_sistem_utilitas' => $input['nama_sistem_utilitas'],
					//'nama_sistem_db' => $input['nama_sistem_db']['kode_nama'],
					'nama_sistem_db' => $nama_db,
					'jenis_lisensi' => $input['jenis_lisensi']['kode_nama'],
					'owner_lisensi' => $input['owner_lisensi'],
					'validitas_lisensi' => $input['validitas_lisensi'],
					//'id_metadata_terkait' => $input['id_metadata_terkait'],
					'kode_l01' => $kode_l01,
					'kode_l02' => $kode_l02,
					'kode_l03' => $kode_l03,
					'kode_l04' => $kode_l04,
					//'id_metadata_terkait' => $input['id_metadata_terkait']['value'],
					'id_metadata_terkait' => $id_metadatas_final, 
					'domain_code' => 'DAI ' . $kode_l04,
					'created_by' => $user_id,
					'created_at' => date('Y-m-d H:i:s')
					];

			$save = $this->domainInfraSoftware->create($data);
			createLog(config('tables.master.domain_infra_software'), 'INS', collect($save)->sortKeys());

			$type 				= 'success';
			$message			= 'Data Domain Infra Software Berhasil Disimpan';

		}catch(\Throwable $t){
			$type 				= 'error';
			$save 				= $t->getMessage();
			$message			= 'Data Domain Infra Software Gagal Disimpan';
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'save' => $save
				 ];
		return json_encode($hasil);
	}

	/**
	 * Get's a data proses bisnis
	 *
	 * @param int
	 * @return collection
	 */
	public function show($id)
	{
		return $this->domainInfraSoftware->findBySlug($id);
	}

	/**
	 * Get's a data daomain infra software by condition
	 *
	 * @param int
	 * @return collection
	 */
	public function getDataBy(Request $request)
	{
		$query = $this->domainInfraSoftware
					  ->select(DB::raw(''.$request->col.' as kode, '.$request->col.' as kode_nama'))
					  ->groupBy($request->col);
		return $query->get();
	}

	/**
	 * Get's a data daomain infra software by condition
	 *
	 * @param int
	 * @return collection
	 */
	public function getDataMetadataKeamanan(Request $request)
	{
    // $query = $this->TmInfraKeamanan
    // 			  ->select(DB::raw(''.$request->col.' as kode, '.$request->col.' as kode_nama'))
    //         ->whereNotNull($request->col)
    // 			  ->groupBy($request->col);
    $query = $this->TmInfraKeamanan
      ->select(DB::raw("TM_INFRA_KEAMANAN.DOMAIN_CODE AS kode, TM_INFRA_KEAMANAN.DOMAIN_CODE||' - '||TRIM(TR_ARS_SPBE.NAMA) AS kode_nama"))
      ->leftJoin(DB::raw('TR_ARS_SPBE'), 'TR_ARS_SPBE.KODE', '=', DB::raw('TM_INFRA_KEAMANAN.RAI_LEVEL_4'))
      ->whereNotNull("DOMAIN_CODE")
      ->groupBy(DB::raw("DOMAIN_CODE, TM_INFRA_KEAMANAN.DOMAIN_CODE||' - '||TRIM(TR_ARS_SPBE.NAMA)"));
      // dd(getQueries($query));
		return $query->get();
	}

	/**
	 * Get's a data daomain infra software by condition
	 *
	 * @param int
	 * @return collection
	 */
	public function getDataMetadataSplp(Request $request)
	{
    // $query = $this->TmInfrastrukturSplp
    // ->select(DB::raw(''.$request->col.' as kode, '.$request->col.' as kode_nama'))
    // ->whereNotNull($request->col)
    // ->groupBy($request->col);
    $query = $this->TmInfrastrukturSplp
    ->select(DB::raw("KODE AS kode, TM_INFRA_SPLP.DOMAIN_CODE||' - '||TRIM(TR_ARS_SPBE.NAMA) AS kode_nama"))
    ->leftJoin(DB::raw('TR_ARS_SPBE'), 'TR_ARS_SPBE.KODE', '=', DB::raw('TM_INFRA_SPLP.RAI_LEVEL_4'))
    ->where('kategori', 'rai')
    ->whereNotNull("DOMAIN_CODE")
    ->groupBy(DB::raw("KODE, TM_INFRA_SPLP.DOMAIN_CODE||' - '||TRIM(TR_ARS_SPBE.NAMA)"));
    // dd(getQueries($query));
		return $query->get();
	}

	public function getUsedSoftware(Request $request)
  	{
		$query = $this->domainInfraSoftware
		->select(DB::raw("rai_level_4 as kode_nama"))
		->distinct("rai_level_4")
		->whereNotNull("rai_level_4");

		return $query->get();
  	}
}
