<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\DomainInfraJip;
use App\Models\InfraJip;
use App\Models\ViewInfraJip;
use App\Models\Opd;
use App\Models\MetadataTerkait;
use App\Models\InfraFasilitas;
use App\Repositories\Contracts\DomainInfraJipRepositoryInterface;

class DomainInfraJipRepository implements DomainInfraJipRepositoryInterface
{
	protected $infraJip;

	protected $columns = [
		'nama_jip' => 'nama_jip',
		'rai_level_1' => 'rai_level_1',
		'rai_level_2' => 'rai_level_2',
		'rai_level_3' => 'rai_level_3',
		'rai_level_4' => 'rai_level_4',
		'instansi_1' => 'instansi_1',
		'instansi_2' => 'instansi_2',
		'deskripsi' => 'deskripsi',
		'domain_code' => 'domain_code'
	  ];

	/**
	 * DomainInfraJip constructor
	 *
	 * @param DomainInfraJip $domainInfraJip
	 */
	public function __construct(DomainInfraJip $domainInfraJip,
								InfraJip $infraJip,
								ViewInfraJip $viewInfraJip,
								Opd $opd,
								MetadataTerkait $metadataTerkait,
								InfraFasilitas $infraFasilitas)
	{
		$this->domainInfraJip  	= $domainInfraJip;
		$this->infraJip  		= $infraJip;
		$this->viewInfraJip  	= $viewInfraJip;
		$this->opd 				= $opd;
		$this->metadataTerkait	= $metadataTerkait;
		$this->infraFasilitas	= $infraFasilitas;
	}

	/**
	 * Get's Domain Infra Jip
	 *
	 * @return mixed
	 */
	public function dataIntraPemerintah(Request $request)
	{
		$query = $this->viewInfraJip
					  ->orderBy('id', 'desc')
					  ->where('deleted_by', null);

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
	 * Save Data Domain Infra JIP.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainInfraJip($request){
		$input 		= $request->all();
		$user_id 	= auth()->user()->v_userid;
		try
		{
			$domain_code 	= 'DAI '.$input['rai_level_4']['kode'];
			// $opd_id_1	 = (isset($input['owner_name_arr']['opd_id']) && $input['owner_name_arr']['opd_id'] != '-') ? $input['owner_name_arr']['opd_id'] : '';
			$opd_id_2	 	= (isset($input['instansi_2']['opd_id']) && $input['instansi_2']['opd_id']=='-') ? '' : $input['instansi_2']['opd_id'];
			$owner_name 	= (isset($input['ownership']['kode']) && $input['ownership']['kode'] != 'Milik Sendiri') ? $input['owner_name'] : ((isset($input['owner_name_arr']['opd_id']) && $input['owner_name_arr']['opd_id'] == '-') ? $input['other_pemilik']:$input['owner_name_arr']['akronim'] );

			$infraJipDb					= new InfraJip();
			$infraJipDb->nama_jip		= $input['nama_jip'];
			$infraJipDb->opd_id_1 		= 'C01';
			$infraJipDb->opd_id_2 		= $opd_id_2;
			$infraJipDb->rai_level_1 	= $input['rai_level_1']['kode'];
			$infraJipDb->rai_level_2 	= $input['rai_level_2']['kode'];
			$infraJipDb->rai_level_3 	= $input['rai_level_3']['kode'];
			$infraJipDb->rai_level_4 	= $input['rai_level_4']['kode'];
			$infraJipDb->opd_2_lainnya 	= isset($input['other_instansi2']) && $opd_id_2 == ''?$input['other_instansi2'] : '';
			$infraJipDb->deskripsi 		= $input['deskripsi'];
			$infraJipDb->jenis 			= $input['jenis']['kode'];
			$infraJipDb->owner_name 	= $owner_name;
			$infraJipDb->ownership 		= $input['ownership']['kode'];
			$infraJipDb->unit_oper 		= $input['unit_oper'];
			$infraJipDb->bandwith 		= $input['bandwith'];
			$infraJipDb->media_type 	= $input['media_type']['kode'];
			$infraJipDb->other_media 	= $input['media_type']['kode']=='Lainnya'? $input['other_media']:'';
			$infraJipDb->primary_backup = $input['primary_backup']['kode'];
			$infraJipDb->domain_code	= $domain_code;
			$infraJipDb->created_by		= $user_id;
			$infraJipDb->save();
			createLog(config('tables.master.infra_jip'), 'INS', collect($infraJipDb)->sortKeys());

			$lastIdJip	= $infraJipDb->id;
			$metadata 	= collect($request->id_metadata_terkait);

			$metadata->each(function ($item, $key) use($domain_code,$lastIdJip )
			{
				$dataMetadata = ['domain_name' => 'DOMAIN_INFRA_JIP',
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
			$message			= 'Data Tambah Domain Infra JIP Berhasil Disimpan';

		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Tambah Domain Infra JIP Gagal Disimpan '.$errorMsg;
			$save 				= '';
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}

	/**
	 * Save Update Data Domain Infra JIP .
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainInfraJip($request){
		$input 		= $request->all();
		$user_id 	= auth()->user()->v_userid;

		DB::beginTransaction();
		try
		{
			/**TM_INFRA_JIP */
			$domain_code = 'DAI '.$input['rai_level_4']['kode'];
			$opd_id_2	 = (isset($input['instansi_2']['opd_id']) && $input['instansi_2']['opd_id']=='-') ? '' : $input['instansi_2']['opd_id'];

			$owner_name = (isset($input['ownership']['kode']) && $input['ownership']['kode'] != 'Milik Sendiri') ? $input['owner_name'] : ((isset($input['owner_name_arr']['opd_id']) && $input['owner_name_arr']['opd_id'] == '-') ? $input['other_pemilik']:$input['owner_name_arr']['akronim'] );

			$data = ['nama_jip' 		=> $input['nama_jip'],
					 'opd_id_1' 		=> 'C01',
					 'opd_id_2' 		=> $opd_id_2,
					 'rai_level_1' 		=> $input['rai_level_1']['kode'],
					 'rai_level_2' 		=> $input['rai_level_2']['kode'],
					 'rai_level_3' 		=> $input['rai_level_3']['kode'],
					 'rai_level_4' 		=> $input['rai_level_4']['kode'],
					 'opd_2_lainnya' 	=> isset($input['other_instansi2']) && $opd_id_2 == ''?$input['other_instansi2'] : '',
					 'deskripsi' 		=> $input['deskripsi'],
					 'jenis' 			=> $input['jenis']['kode'],
					 'owner_name' 		=> $owner_name,
					 'ownership' 		=> $input['ownership']['kode'],
					 'unit_oper' 		=> $input['unit_oper'],
					 'bandwith' 		=> $input['bandwith'],
					 'media_type' 		=> $input['media_type']['kode'],
					 'other_media' 		=> $input['media_type']['kode']=='Lainnya'? $input['other_media']:'',
					 'primary_backup' 	=> $input['primary_backup']['kode'],
					 'domain_code'		=> $domain_code,
					 'updated_by' 		=> $user_id
					];
			$post = $this->infraJip
						->where('id',$input['id'])
						->update($data);

			createLog(config('tables.master.infra_jip'), 'UPD', collect($post)->sortKeys());

			/**TM_METADATA_TERKAIT */
			$lastIdJip	 = $input['id'];
			$metadata 	 = collect($request->id_metadata_terkait);
			$delMetadata = $this->metadataTerkait
								->where('infra_id', $lastIdJip)
								->where('domain_name', 'DOMAIN_INFRA_JIP')
								->delete();
			createLog(config('tables.master.metadata_terkait'), 'DEL', collect($delMetadata)->sortKeys());

			$metadata->each(function ($item, $key) use($domain_code,$lastIdJip )
			{
				$dataMetadata = ['domain_name' => 'DOMAIN_INFRA_JIP',
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
			$message			= 'Data Domain Infra JIP Berhasil Diubah';
			DB::commit();
		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Domain Infra JIP Gagal Diubah '.$errorMsg;
			DB::rollBack();
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}

	/**
	 * Delete Data Domain Infra JIP.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainInfraJip($request)
	{
		try{
			$user_id 	= auth()->user()->v_userid;
			$data = ['deleted_by' => $user_id,
					 'deleted_at' => date('Y-m-d H:i:s')
					];
			$del = $this->infraJip
						->where('id',$request->data['id'])
						->update($data);
			createLog(config('tables.master.infra_jip'), 'DEL', collect($del)->sortKeys());

			$type 				= 'success';
			$message			= 'Data Domain Infra JIP Berhasil Dihapus	';
			$errorMsg			= '';
		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Domain Infra JIP Gagal Dihapus '.$errorMsg;
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
	public function searchIntraPemerintah(Request $request)
	{
		return $this->infraJip->where('id',$request->id_intra)
							  ->with(['metadataTerkait' => function($query) {
											$query->where('DOMAIN_NAME','DOMAIN_INFRA_JIP');
										}
									])
							  ->first();
	}

	/**
	 * Get's Domain Infra Jip data by
	 *
	 * @return mixed
	 */
	public function getDataBy(Request $request)
	{
    $query = $this->infraJip
				  ->join('tr_ars_spbe','tr_ars_spbe.kode','tm_infra_jip.rai_level_4')
				  ->select(DB::raw('tm_infra_jip.' . $request->col . ' as kode, tm_infra_jip.' . $request->col . '||\' - \'||tr_ars_spbe.nama as kode_nama, id_infra_jip'))
				  ->where('deleted_by',null)
				  ->groupBy(DB::raw('tm_infra_jip.' . $request->col. ',id_infra_jip, tm_infra_jip.' . $request->col . '||\' - \'||tr_ars_spbe.nama'));
	return $query->get();
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
					  ->isInfraJip()
					  ->select(['opd_id','nama_opd', 'akronim']);
		if(isset($request->opd_id)){
			$query->where('opd_id',$request->opd_id);
		}

		return $query->get();
	}

	/**
	 * Get's a data perangkat daerah nama pemilik
	 *
	 * @param int
	 * @return collection
	 */
	// public function dataPerangkatDaerah(Request $request)
	// {
    // $query = $this->opd
    //   ->isOpd()
    //   ->select(['opd_id', 'nama_opd', 'akronim']);
    // if (isset($request->opd_id)) {
    //   $query->where('opd_id', $request->opd_id);
    // }

    // return $query->get();
	// }

	/**
	 * Get's a data perangkat daerah nama pemilik
	 *
	 * @param int
	 * @return collection
	 */
	public function dataPerangkatDaerahPemilik(Request $request)
	{
		$query = $this->opd
					  ->isOpd()
					  ->select(['opd_id','nama_opd', 'akronim']);
		if(isset($request->opd_id)){
			$query->where('opd_id',$request->opd_id);
		}

		return $query->get();
	}

	/**
	 * Get's Domain Infra Fasilitas Domain Code
	 *
	 * @return mixed
	 */
	public function getDomainCode(Request $request)
	{
		$query 		= $this->infraFasilitas
					  ->select(DB::raw(''.$request->col.' as kode, '.$request->col.'||\' - \'||nama as kode_nama'))
					  ->groupBy(DB::raw($request->col.','.$request->col.'||\' - \'||nama') );

		if(isset($request->opd_id)){
			$query->where('opd_id',$request->opd_id);
		}
		if(isset($request->id_metadata_terkait)){
			$query->whereIn($request->col, explode(';',$request->id_metadata_terkait));
		}
		return $query->get();
	}
}
