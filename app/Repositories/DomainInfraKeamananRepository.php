<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\{DomainInfraKeamanan, DomainInfraFasilitas, TmInfraKeamanan, TmMetadataTerkait};
use App\Repositories\Contracts\DomainInfraKeamananRepositoryInterface;

class DomainInfraKeamananRepository implements DomainInfraKeamananRepositoryInterface
{  
	protected $columns = [
		'rai_level_1' => 'rai_level_1',
		'rai_level_2' => 'rai_level_2',
		'rai_level_3' => 'rai_level_3',
		'rai_level_4' => 'rai_level_4',
		'nama' => 'nama',
		'instansi' => 'opd.nama_opd',
		'jenis' => 'jenis',
		'deskripsi' => 'deskripsi',
		'tipe' => 'tipe',
		'nama_owner' => 'nama_owner',
		'status_ownership' => 'status_ownership',
		'keterangan' => 'keterangan',
		'domain_code' => 'domain_code'
	  ];

	/**
	 * DomainInfraKeamanan constructor
	 *
	 * @param DomainInfraKeamanan $domainInfraKeamanan
	 */
	public function __construct(
		TmInfraKeamanan $domainInfraKeamanan,
		DomainInfraFasilitas $domainInfraFasilitas,
		TmMetadataTerkait $tmMetadataTerkait
		) 
	{
		$this->domainInfraKeamanan  = $domainInfraKeamanan;
		$this->domainInfraFasilitas = $domainInfraFasilitas;
		$this->tmMetadataTerkait = $tmMetadataTerkait;
	}

	/**
	 * Get's Domain Infra Perangkat Keamanan
	 *
	 * @return mixed
	 */
	public function dataInfraKeamanan(Request $request)
	{		
		$query = $this->domainInfraKeamanan
					->select('tm_infra_keamanan.*', 
						'a.kode_nama as rai_level_1_nama',
						'b.kode_nama as rai_level_2_nama',
						'c.kode_nama as rai_level_3_nama',
						'd.kode_nama as rai_level_4_nama'
					)
					->leftJoin('tr_ars_spbe a', function($join) {
						$join->on('tm_infra_keamanan.RAI_LEVEL_1', '=', 'a.kode')
						->where('a.kategori', '=', 'rai');
					})
					->leftJoin('tr_ars_spbe b', function($join) {
						$join->on('tm_infra_keamanan.RAI_LEVEL_2', '=', 'b.kode')
						->where('b.kategori', '=', 'rai');
					})
					->leftJoin('tr_ars_spbe c', function($join) {
						$join->on('tm_infra_keamanan.RAI_LEVEL_3', '=', 'c.kode')
						->where('c.kategori', '=', 'rai');
					})
					->leftJoin('tr_ars_spbe d', function($join) {
						$join->on('tm_infra_keamanan.RAI_LEVEL_4', '=', 'd.kode')
						->where('d.kategori', '=', 'rai');
					})
					->leftJoin('tr_opd opd', 'tm_infra_keamanan.opd_id', '=', 'opd.opd_id')
					->active()
					->orderBy('tm_infra_keamanan.id', 'desc');

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
		if(isset($request->opd_id)){
			$opd_id = $request->opd_id;
			$query->where('tm_infra_keamanan.opd_id', '=', $opd_id);
		} else {
			return [];
		}
		return $query->paginate($request->limit);
	}

	
	/**
	 * Save Data Domain Infra Keamanan.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainInfraKeamanan($request){
		$input 		= $request->all();
		$user_id 	= auth()->user()->v_userid;
		
		DB::beginTransaction();
		try
		{
			$domain_code = 'DAI '.$input['rai_level_4'];

			$data = ['nama' 				=> $input['nama'], //
					'opd_id'				=> $input['opd_id'],
					'rai_level_1' 			=> $input['rai_level_1'], 
					'rai_level_2' 			=> $input['rai_level_2'], 
					'rai_level_3' 			=> $input['rai_level_3'],
					'rai_level_4' 			=> $input['rai_level_4'],
					'jenis' 				=> $input['jenis'], 
					'deskripsi' 			=> $input['deskripsi'],
					'tipe' 					=> $input['tipe'],
					'nama_owner' 			=> $input['pemilik'], //
					'status_ownership' 		=> $input['kepemilikan'], //					 					
					'unit_pengelola' 		=> $input['pengelola'], //
					'keterangan' 			=> $input['keterangan'], 
					'asal' 					=> $input['asal'], //
					'deskripsi_asal' 		=> $input['deskripsi_asal'], //
					'domain_code'			=> $domain_code,
					'created_by' 			=> $user_id,
					'created_at' 			=> date('Y-m-d H:i:s')
					];
			$save 				= $this->domainInfraKeamanan->create($data);			
			createLog(config('tables.master.tm_infra_keamanan'), 'INS', collect($save)->sortKeys());

			foreach ($input['id_metadata_terkait'] as $i => $value) {
				$metadata_saved = $this->tmMetadataTerkait->create([
					'domain_name' => 'DOMAIN_INFRA_SECDEV',
					'domain_code' => $domain_code,
					'domain_terkait' => 'DOMAIN_INFRA_FASILITAS',
					'domain_terkait_code' => $value['kode'],
					'infra_id' => $save->id
				]);
			}

			$type 				= 'success';
			$errorMsg			= '';
			$message			= 'Data Tambah Domain Infra Perangkat Keamanan Berhasil Disimpan';
			DB::commit();

		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Tambah Domain Infra Perangkat Keamanan Gagal Disimpan '.$errorMsg;
			$save 				= '';
			DB::rollBack();
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}
	
	/**
	 * Save Update Data Domain Infra Keamanan .
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainInfraKeamanan( $request){
		$input 		= $request->all();
		$user_id 	= auth()->user()->v_userid;

		$before = $this->domainInfraKeamanan->find($input['id']);

		DB::beginTransaction();
		try
		{
			$domain_code = 'DAI '.$input['rai_level_4'];

			$data = ['nama' 				=> $input['nama'], //
					'opd_id'				=> $input['opd_id'],
					'rai_level_1' 			=> $input['rai_level_1'], 
					'rai_level_2' 			=> $input['rai_level_2'], 
					'rai_level_3' 			=> $input['rai_level_3'],
					'rai_level_4' 			=> $input['rai_level_4'],
					'jenis' 				=> $input['jenis'], 
					'deskripsi' 			=> $input['deskripsi'],
					'tipe' 					=> $input['tipe'],
					'nama_owner' 			=> $input['pemilik'], //
					'status_ownership' 		=> $input['kepemilikan'], //					 					
					'unit_pengelola' 		=> $input['pengelola'], //
					'keterangan' 			=> $input['keterangan'], 
					'asal' 					=> $input['asal'], //
					'deskripsi_asal' 		=> $input['deskripsi_asal'], //
					'domain_code'			=> $domain_code,
					'updated_by' 			=> $user_id,
					'updated_at' 			=> date('Y-m-d H:i:s')
					];

			$updateData = $this->domainInfraKeamanan
						->where('id',$input['id'])
						->update($data);

			createLog(config('tables.master.tm_infra_keamanan'), 'UPD', [
				'before' => collect($before)->sortKeys(),
				'after' => collect($updateData)->sortKeys()
			]);

			$this->tmMetadataTerkait
			->where('infra_id', '=', $input['id'])
			->where('domain_name', '=', 'DOMAIN_INFRA_SECDEV')
			->delete();
			
			foreach ($input['id_metadata_terkait'] as $i => $value) {
				$metadata_saved = $this->tmMetadataTerkait->create([
					'domain_name' => 'DOMAIN_INFRA_SECDEV',
					'domain_code' => $domain_code,
					'domain_terkait' => 'DOMAIN_INFRA_FASILITAS',
					'domain_terkait_code' => $value['kode'],
					'infra_id' => $input['id']
				]);
			}

			$type 				= 'success';
			$errorMsg			= '';
			$message			= 'Data Domain Infra Perangkat Keamanan Berhasil Diubah';
			DB::commit();
		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Domain Infra Perangkat Keamanan Gagal Diubah '.$errorMsg;
			DB::rollBack();
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}

	/**
	 * Delete Data Domain Infra Keamanan.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainInfraKeamanan($request)
	{
		try{			
			$user_id 	= auth()->user()->v_userid;
			$data = ['deleted_by' => $user_id,
					'deleted_at' => date('Y-m-d H:i:s')
					];
			$del = $this->domainInfraKeamanan
						->where('id',$request->data['id'])
						->update($data);
			createLog(config('tables.master.tm_infra_keamanan'), 'DEL', collect($del)->sortKeys());

			$type 				= 'success';
			$message			= 'Data Domain Infra Perangkat Keamanan Berhasil Dihapus	';
			$errorMsg			= '';
		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Domain Infra Perangkat Keamanan Gagal Dihapus '.$errorMsg;
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}
	
	/**
	 * Get's a data domain Infra Keamanan
	 *
	 * @param int
	 * @return collection
	 */
	public function searchInfraKeamanan(Request $request)
	{
		$infra_keamanan = $this->domainInfraKeamanan->findBySlug($request->id_infra);
		if ($infra_keamanan) {
			$query = $this->domainInfraKeamanan
				->with('idMetadataTerkait')
				->select('tm_infra_keamanan.*', 
					'a.kode_nama as rai_level_1_nama',
					'b.kode_nama as rai_level_2_nama',
					'c.kode_nama as rai_level_3_nama',
					'd.kode_nama as rai_level_4_nama'
				)
				->leftJoin('tr_ars_spbe a', function($join) {
					$join->on('tm_infra_keamanan.RAI_LEVEL_1', '=', 'a.kode')
					->where('a.kategori', '=', 'rai');
				})
				->leftJoin('tr_ars_spbe b', function($join) {
					$join->on('tm_infra_keamanan.RAI_LEVEL_2', '=', 'b.kode')
					->where('b.kategori', '=', 'rai');
				})
				->leftJoin('tr_ars_spbe c', function($join) {
					$join->on('tm_infra_keamanan.RAI_LEVEL_3', '=', 'c.kode')
					->where('c.kategori', '=', 'rai');
				})
				->leftJoin('tr_ars_spbe d', function($join) {
					$join->on('tm_infra_keamanan.RAI_LEVEL_4', '=', 'd.kode')
					->where('d.kategori', '=', 'rai');
				})
				->where('id', $infra_keamanan->id);

			return $query->first();
		} else {
			return null;
		}

		//dd($request->all());
	}

	public function getMetadata(Request $request)
  	{
		$query = $this->domainInfraFasilitas->distinct()
		->select(DB::raw("domain_code as kode, nama as kode_nama"));

		return $query->get();
  	}
}
