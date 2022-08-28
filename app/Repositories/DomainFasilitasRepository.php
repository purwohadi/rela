<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\{DomainInfraFasilitas, InfraFasilitas, ViewInfraFasilitas, Opd, MetadataTerkait};
use App\Repositories\Contracts\DomainFasilitasRepositoryInterface;
use App\Models\Traits\HasHashSlug;

class DomainFasilitasRepository implements DomainFasilitasRepositoryInterface
{
	use HasHashSlug;
	protected $opd, $infraFasilitas, $metadataTerkait, $viewInfraFasilitas;

	protected $columns = [
		'rai_level_1' => 'rai_level_1',
		'rai_level_2' => 'rai_level_2',
		'rai_level_3' => 'rai_level_3',
		'rai_level_4' => 'rai_level_4',
		'nama' => 'nama',
		'instansi' => 'instansi',
		'lokasi' => 'lokasi',
		'domain_code' => 'domain_code'
	  ];

  /**
   * DomainInfraFasilitas constructor
   *
   * @param DomainInfraFasilitas $domainInfraFasilitas
   * @param InfraFasilitas $InfraFasilitas
   */
	public function __construct(
    DomainInfraFasilitas $domainInfraFasilitas,
    InfraFasilitas $infraFasilitas,
	ViewInfraFasilitas $viewInfraFasilitas,
	Opd $opd,
	MetadataTerkait $metadataTerkait
  )
	{
		$this->domainInfraFasilitas  	= $domainInfraFasilitas;
		$this->infraFasilitas  			= $infraFasilitas;
		$this->viewInfraFasilitas  		= $viewInfraFasilitas;
		$this->opd						= $opd;
		$this->metadataTerkait			= $metadataTerkait;
	}

	/**
	 * Get's Domain Infra Fasilitas Domain Code
	 *
	 * @return mixed
	 */
	public function getDomainCode(Request $request)
	{
		$query = $this->domainInfraFasilitas
					  ->select(DB::raw(''.$request->col.' as kode, '.$request->col.' as kode_nama'))
					  ->groupBy($request->col);

		if(isset($request->opd_id)){
			$query->where('opd_id',$request->opd_id);
		}
		if(isset($request->id_metadata_terkait)){
			$query->whereIn($request->col, explode(';',$request->id_metadata_terkait));
		}
		return $query->get();
	}

	/**
	 * Get's Domain Infra Fasilitas
	 *
	 * @return mixed
	 */
	public function dataIntraFasilitas(Request $request)
	{
		$query = $this->viewInfraFasilitas
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
		return $query->paginate($request->limit);
	}


	/**
	 * Save Data Domain Infra Fasilitas.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainInfraFasilitas($request){
		$input 		= $request->all();
		$user_id 	= auth()->user()->v_userid;
		// dd($request->input());
		try
		{
			$opd_id = $input['instansi']['opd_id'];

			if(isset($input['ownership']['kode']) && ($input['ownership']['kode'] != 'Milik Sendiri' && $input['ownership']['kode'] != 'Milik Instansi Pemerintah Lain') ){
				$owner_name = $input['nama_pemilik'];	
			}
			elseif(isset($input['ownership']['kode']) && $input['ownership']['kode'] == 'Milik Sendiri' )
			{
				$owner_name = $input['instansi']['akronim'];	
				// $opd_id		= $input['instansi']['opd_id'];	
			}
			elseif(isset($input['ownership']['kode']) && $input['ownership']['kode'] == 'Milik Instansi Pemerintah Lain')
			{
				$owner_name = $input['nama_pemilik']['akronim'];	
				if($input['nama_pemilik']['akronim'] == 'Lainnya'){
					$owner_name = $input['other_pemilik'];	
				}
			}
			
			/**TM_INFRA_FASILITAS */
			$infraFasilitasDb						= new InfraFasilitas();
			$infraFasilitasDb->nama 				= $input['nama'];
			$infraFasilitasDb->opd_id				= $opd_id;
			$infraFasilitasDb->rai_level_1			= $input['rai_level_1']['kode'];
			$infraFasilitasDb->rai_level_2			= $input['rai_level_2']['kode'];
			$infraFasilitasDb->rai_level_3			= $input['rai_level_3']['kode'];
			$infraFasilitasDb->deskripsi			= $input['deskripsi'];
			$infraFasilitasDb->kode_model_referensi	= $input['kode_model_referensi'];
			$infraFasilitasDb->lokasi				= $input['lokasi'];
			$infraFasilitasDb->ownership			= $input['ownership']['kode'];
			$infraFasilitasDb->nama_pemilik			= $owner_name;
			$infraFasilitasDb->unit_pj				= $input['unit_pj']['opd_id'];
			$infraFasilitasDb->bandwidth_internet	= $input['bandwidth_internet'];
			$infraFasilitasDb->bandwidth_intranet	= $input['bandwidth_intranet'];
			$infraFasilitasDb->tipe_pengamanan		= $input['tipe_pengamanan'];
			$infraFasilitasDb->klasifikasi_tier		= $input['klasifikasi_tier']['kode'];
			$infraFasilitasDb->created_by			= $user_id;
			$infraFasilitasDb->save();
			createLog(config('tables.master.infra_fasilitas'), 'INS', collect($infraFasilitasDb)->sortKeys());
			/**END TM_INFRA_FASILITAS */

			/**TM_METADATA_TERKAIT */			
			$lastIdFasil 	= $infraFasilitasDb->id;
			$domain_code 	= 'DAI '.$input['rai_level_3']['kode'].'.'.$lastIdFasil;
			$metadata 		= collect($request->id_metadata_jip);

			$metadata->each(function ($item, $key) use($domain_code, $lastIdFasil ) 
			{
				$dataMetadata = ['domain_name' => 'DOMAIN_INFRA_FASILITAS',
								 'domain_code' => $domain_code,
								 'domain_terkait' => 'DOMAIN_INFRA_JIP',
								 'domain_terkait_code' => $item['kode'],
								 'infra_id' => $lastIdFasil
								];
				$saveMetadata	= $this->metadataTerkait
									   ->create($dataMetadata);
				createLog(config('tables.master.metadata_terkait'), 'INS', collect($saveMetadata)->sortKeys());
			});
			/**END TM_METADATA_TERKAIT */

			$type 				= 'success';
			$errorMsg			= '';
			$message			= 'Data Tambah Domain Infra Fasilitas Berhasil Disimpan';

		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Tambah Domain Infra Fasilitas Gagal Disimpan '.$errorMsg;
			$save 				= '';
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}

	/**
	 * Save Update Data Domain Infra Fasilitas .
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainInfraFasilitas( $request){
		$input 		= $request->all();
		$user_id 	= auth()->user()->v_userid;
	
		DB::beginTransaction();
		try
		{
			$opd_id = $input['instansi']['opd_id'];

			if(isset($input['ownership']['kode']) && ($input['ownership']['kode'] != 'Milik Sendiri' && $input['ownership']['kode'] != 'Milik Instansi Pemerintah Lain') ){
				$owner_name = $input['nama_pemilik'];	
			}
			elseif(isset($input['ownership']['kode']) && $input['ownership']['kode'] == 'Milik Sendiri' )
			{
				$owner_name = $input['instansi']['akronim'];	
			}
			elseif(isset($input['ownership']['kode']) && $input['ownership']['kode'] == 'Milik Instansi Pemerintah Lain')
			{
				$owner_name = $input['nama_pemilik']['akronim'];	
				if($input['nama_pemilik']['akronim'] == 'Lainnya'){
					$owner_name = $input['other_pemilik'];	
				}
			}

			/**TM_INFRA_FASILITAS */
			$data = ['nama' 				=> $input['nama'],
					 'opd_id' 				=> $opd_id,
					'rai_level_1' 			=> $input['rai_level_1']['kode'],
					'rai_level_2' 			=> $input['rai_level_2']['kode'],
					'rai_level_3' 			=> $input['rai_level_3']['kode'],
					'deskripsi' 			=> $input['deskripsi'],
					'kode_model_referensi' 	=> $input['kode_model_referensi'],
					'lokasi' 				=> $input['lokasi'],
					'ownership' 			=> $input['ownership']['kode'],
					'nama_pemilik' 			=> $owner_name,
					'unit_pj' 				=> $input['unit_pj']['opd_id'],
					'bandwidth_internet' 	=> $input['bandwidth_internet'],
					'bandwidth_intranet' 	=> $input['bandwidth_intranet'],
					'tipe_pengamanan' 		=> $input['tipe_pengamanan'],
					'klasifikasi_tier' 		=> $input['klasifikasi_tier']['kode'],
					'updated_by' 			=> $user_id
					];

			$post = $this->infraFasilitas
						->where('id',$input['id'])
						->update($data);
			createLog(config('tables.master.infra_fasilitas'), 'UPD', collect($post)->sortKeys());
			/**END TM_INFRA_FASILITAS */

			/**TM_METADATA_TERKAIT */
			$lastIdFasil 	= $input['id'];
			// dd($lastIdFasil);
			$domain_code 	= 'DAI '.$input['rai_level_3']['kode'].'.'.$lastIdFasil;
			$metadata 	 	= collect($request->id_metadata_jip);			
			$delMetadata 	= $this->metadataTerkait
								   ->where('infra_id', $lastIdFasil)
								   ->where('domain_name', 'DOMAIN_INFRA_FASILITAS')
								   ->delete();
			createLog(config('tables.master.metadata_terkait'), 'DEL', collect($delMetadata)->sortKeys());
			
			$metadata->each(function ($item, $key) use($domain_code,$lastIdFasil ) 
			{
				$dataMetadata = ['domain_name' => 'DOMAIN_INFRA_FASILITAS',
								'domain_code' => $domain_code,
								'domain_terkait' => 'DOMAIN_INFRA_JIP',
								'domain_terkait_code' => $item['kode'],
								'infra_id' => $lastIdFasil
							   ];
				$saveMetadata	= $this->metadataTerkait
									   ->create($dataMetadata);
				createLog(config('tables.master.metadata_terkait'), 'INS', collect($saveMetadata)->sortKeys());
			});
			/**END TM_METADATA_TERKAIT*/

			$type 				= 'success';
			$errorMsg			= '';
			$message			= 'Data Domain Infra Fasilitas Berhasil Diubah';
			DB::commit();
		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Domain Infra Fasilitas Gagal Diubah '.$errorMsg;
			DB::rollBack();
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}

	/**
	 * Delete Data Domain Infra Fasilitas.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainInfraFasilitas($request)
	{
		try{
			$user_id 	= auth()->user()->v_userid;
			$data 		= ['deleted_by' => $user_id,
						   'deleted_at' => date('Y-m-d H:i:s')
						  ];
			$del = $this->infraFasilitas
						->where('id',$request->data['id'])
						->update($data);
			createLog(config('tables.master.infra_fasilitas'), 'DEL', collect($del)->sortKeys());

			$type 				= 'success';
			$message			= 'Data Domain Infra Fasilitas Berhasil Dihapus	';
			$errorMsg			= '';
		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Domain Infra Fasilitas Gagal Dihapus '.$errorMsg;
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}

	/**
	 * Get's a data domain Infra Fasilitas
	 *
	 * @param int
	 * @return collection
	 */
	public function searchIntraFasilitas(Request $request)
	{
		$vwFasilitas 	= $this->viewInfraFasilitas->findBySlug($request->id_fasilitas);
		$data 	= $this->viewInfraFasilitas
					   ->where('id',$vwFasilitas['id'])
					   ->with(['metadataTerkait' => function($query) {
										$query->join('tm_infra_jip','tm_metadata_terkait.domain_terkait_code','tm_infra_jip.domain_code')
											  ->join('tr_ars_spbe','tr_ars_spbe.kode','tm_infra_jip.rai_level_4')
											  ->select([DB::raw('tm_metadata_terkait.infra_id, tm_metadata_terkait.domain_terkait_code AS kode, tm_metadata_terkait.domain_terkait_code ||\' - \'|| tr_ars_spbe.nama kode_nama')])
										      ->where('DOMAIN_NAME','DOMAIN_INFRA_FASILITAS')
											  ->groupBy(DB::raw('tm_metadata_terkait.infra_id, tm_metadata_terkait.domain_terkait_code, tm_metadata_terkait.domain_terkait_code ||\' - \'|| tr_ars_spbe.nama'));
									}
							  ])
					   ->first();
		
		return $data;
	}

	/**
	 * Get's a data daomain infra software by condition
	 *
	 * @param int
	 * @return collection
	 */
	public function getDataBy(Request $request)
	{
		$query = $this->infraFasilitas
					  ->select(DB::raw(''.$request->col.' as kode, '.$request->col.' as kode_nama, nama as nama'))
					  ->groupBy($request->col, 'nama');
		return $query->get();
	}

	/**
	 * Get's a data perangkat daerah instansi lain
	 *
	 * @param int
	 * @return collection
	 */
	public function dataPerangkatDaerahInstansiLain(Request $request)
	{
		$query = $this->opd
					  ->isOpd()
					  ->select(['opd_id','nama_opd', 'akronim']);

		if(isset($request->opd_id)){
			$query->where('opd_id',$request->opd_id);
		}

		if(isset($request->notOpdId)){
			$query->where('opd_id','!=',$request->notOpdId);
		}

		return $query->get();
	}
}
