<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\DomainInfraPheri;
use App\Models\InfraPheri;
use App\Models\ViewInfraPheri;
use App\Models\Opd;
use App\Models\MetadataTerkait;
use App\Repositories\Contracts\DomainPeriferalRepositoryInterface;

class DomainPeriferalRepository implements DomainPeriferalRepositoryInterface
{  
	
	protected $domainInfraPheri;
	protected $infraPheri;
	protected $viewInfraPheri;
	protected $opd;

	protected $columns = [
		'rai_level_1' => 'rai_level_1',
		'rai_level_2' => 'rai_level_2',
		'rai_level_3' => 'rai_level_3',
		'rai_level_4' => 'rai_level_4',
		'nama' => 'nama',
		'deskripsi' => 'deskripsi',
		'nm_perangkat_daerah' => 'nm_perangkat_daerah',
		'tipe' => 'tipe',
		'lokasi' => 'lokasi',
		'domain_code' => 'domain_code'
	  ];

	/**
	 * DomainInfraJip constructor
	 *
	 * @param DomainInfraJip $domainInfraPheri
	 */
	public function __construct(DomainInfraPheri $domainInfraPheri,
								InfraPheri $infraPheri,
								ViewInfraPheri $viewInfraPheri,
								MetadataTerkait $metadataTerkait,
								Opd $opd) 
	{
		$this->domainInfraPheri = $domainInfraPheri;
		$this->infraPheri  		= $infraPheri;
		$this->viewInfraPheri  	= $viewInfraPheri;
		$this->metadataTerkait	= $metadataTerkait;
		$this->opd  			= $opd;
	}

	/**
	 * Get's Domain Infra Pheri
	 *
	 * @return mixed
	 */
	public function dataIntraPheri(Request $request)
	{		
		$query = $this->viewInfraPheri
					  ->orderBy('id', 'desc')
					  ->where('deleted_by', null);
		
		// if(isset($request->opd_id)){
			$query->where('opd_id',$request->opd_id);
		// }

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
		// dd($query->toSql());
		return $query->paginate($request->limit);
	}

	
	/**
	 * Save Data Domain Infra Pheri.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainInfraPheri($request){
		$input 		= $request->all();
		$user_id 	= auth()->user()->v_userid;
		try
		{			
			$domain_code 	= 'DAI '.$input['rai_level_4']['kode'];
						
			/**TM_INFRA_PHERI */
			$infraPheri = new InfraPheri();
			$infraPheri->nama 			= $input['nama'];
			$infraPheri->opd_id 		= $input['instansi']['opd_id'];
			$infraPheri->rai_level_1 	= $input['rai_level_1']['kode'];
			$infraPheri->rai_level_2 	= $input['rai_level_2']['kode'];
			$infraPheri->rai_level_3 	= $input['rai_level_3']['kode'];
			$infraPheri->rai_level_4 	= $input['rai_level_4']['kode'];
			$infraPheri->deskripsi 		= $input['deskripsi'];
			$infraPheri->unit_pengelola = $input['unit_pengelola']['kode'];
			$infraPheri->lokasi 		= $input['lokasi'];
			$infraPheri->tipe 			= $input['tipe']['kode'];
			$infraPheri->domain_code 	= $domain_code;
			$infraPheri->created_by 	= $user_id;
			$infraPheri->save();
			// createLog(config('tables.master.infra_pheri'), 'INS', collect($infraPheri)->sortKeys());
			
			/**TM_METADATA_TERKAIT */
			$lastIdPheri	= $infraPheri->id;
			$metadata 		= collect($request->id_metadata_terkait);
			$metadata->each(function ($item, $key) use($domain_code,$lastIdPheri ) 
			{
				$dataMetadata = ['domain_name' => 'DOMAIN_INFRA_PHERI',
								 'domain_code' => $domain_code,
								 'domain_terkait' => 'DOMAIN_INFRA_FASILITAS',
								 'domain_terkait_code' => $item['kode'],
								 'infra_id' => $lastIdPheri
								];
				$saveMetadata	= $this->metadataTerkait
									   ->create($dataMetadata);
				createLog(config('tables.master.metadata_terkait'), 'INS', collect($saveMetadata)->sortKeys());
			});

			$type 				= 'success';
			$errorMsg			= '';
			$message			= 'Data Tambah Domain Infra Pheri Berhasil Disimpan';

		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Tambah Domain Infra Pheri Gagal Disimpan '.$errorMsg;
			$save 				= '';
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}
	
	/**
	 * Save Update Data Domain Infra Pheri .
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainInfraPheri( $request){
		$input 		= $request->all();
		$user_id 	= auth()->user()->v_userid;

		DB::beginTransaction();
		try
		{
			// dd($request->input());
			/**TM_INFRA_JIP */
			$domain_code = 'DAI '.$input['rai_level_4']['kode'];
			$data = ['nama' => $input['nama'], 
					 'opd_id' => $input['instansi']['opd_id'], 
					 'rai_level_1' => $input['rai_level_1']['kode'], 
					 'rai_level_2' => $input['rai_level_2']['kode'], 
					 'rai_level_3' => $input['rai_level_3']['kode'], 
					 'rai_level_4' => $input['rai_level_4']['kode'], 
					 'deskripsi' => $input['deskripsi'], 
					 'unit_pengelola' => $input['unit_pengelola']['kode'], 
					 'lokasi' => $input['lokasi'], 
					 'tipe' => $input['tipe']['kode'], 
					 'updated_by' => $user_id
					];

			$post = $this->infraPheri
						->where('id',$input['id'])
						->update($data);

			createLog(config('tables.master.infra_pheri'), 'UPD', collect($post)->sortKeys());

			/**TM_METADATA_TERKAIT */
			$lastIdJip	 = $input['id'];
			$metadata 	 = collect($request->id_metadata_terkait);			
			$delMetadata = $this->metadataTerkait
								->where('infra_id', $lastIdJip)
								->where('domain_name', 'DOMAIN_INFRA_PHERI')
								->delete();
			createLog(config('tables.master.metadata_terkait'), 'DEL', collect($delMetadata)->sortKeys());
			
			$metadata->each(function ($item, $key) use($domain_code,$lastIdJip ) 
			{
				$dataMetadata = ['domain_name' => 'DOMAIN_INFRA_PHERI',
								 'domain_code' => $domain_code,
								 'domain_terkait' => 'DOMAIN_INFRA_FASILITAS',
								 'domain_terkait_code' => $item['kode'],
								 'infra_id' => $lastIdJip
								];
				$saveMetadata	= $this->metadataTerkait
									   ->create($dataMetadata);
				createLog(config('tables.master.metadata_terkait'), 'INS', collect($saveMetadata)->sortKeys());
			});

			$type 				= 'success';
			$errorMsg			= '';
			$message			= 'Data Domain Infra Pheri Berhasil Diubah';
			DB::commit();
		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Domain Infra Pheri Gagal Diubah '.$errorMsg;
			DB::rollBack();
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}

	/**
	 * Delete Data Domain Infra Pheri.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainInfraPheri($request)
	{
		try{			
			$user_id 	= auth()->user()->v_userid;
			$data = ['deleted_by' => $user_id,
					 'deleted_at' => date('Y-m-d H:i:s')
					];
			$del = $this->infraPheri
						->where('id',$request->data['id'])
						->update($data);
			createLog(config('tables.master.infra_pheri'), 'DEL', collect($del)->sortKeys());

			$type 				= 'success';
			$message			= 'Data Domain Infra Pheri Berhasil Dihapus	';
			$errorMsg			= '';
		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Domain Infra Pheri Gagal Dihapus '.$errorMsg;
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}
	
	/**
	 * Get's a data domain Infra JIP
	 *
	 * @param int
	 * @return collection
	 */
	public function searchIntraPheri(Request $request)
	{
		return $this->infraPheri
					->where('id',$request->id_pheri)
					->with(['metadataTerkait' => function($query) {
									$query->where('DOMAIN_NAME','DOMAIN_INFRA_PHERI');
								}
							])
					->first();
	}

	/**
	 * Get's a data perangkat daerah
	 *
	 * @param int
	 * @return collection
	 */
	public function dataPerangkatDaerah(Request $request)
	{
		$query = $this->opd
					  ->isOpd()
					  ->select(['opd_id','nama_opd', 'akronim']);
		if(isset($request->opd_id)){
			$query->where('opd_id',$request->opd_id);
		}

		return $query->get();
	}
}
