<?php

namespace App\Repositories;

use App\Http\Resources\Domain\DomainAplikasiDetailResources;
use App\Http\Resources\Domain\DomainAplikasiResources;
use App\Http\Resources\InfraSPLPMinResources;
use App\Models\AplikasiBasis;
use App\Models\AplikasiData;
use App\Models\AplikasiDetail;
use App\Models\AplikasiLayanan;
use App\Models\AplikasiLuaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\DomainAplikasi;
use App\Models\TmAplikasi;
use App\Models\TmInfrastrukturSplp;
use App\Models\ViewAplikasi;
use App\Repositories\Contracts\DomainAplikasiRepositoryInterface;
use Illuminate\Validation\ValidationException;

class DomainAplikasiRepository implements DomainAplikasiRepositoryInterface
{  
	protected $columns = [
		'raa_level1' => 'raa_level_1',
		'raa_level2' => 'raa_level_2',
		'raa_level3' => 'raa_level_3',
		'raa_level4' => 'raa_level_4',
		'nama_apl' => 'nama_apl',
		'app_ownership' => 'app_ownership'
	];
	/**
	 * DomainAplikasiRepository constructor
	 *
	 * @param DomainAplikasi $domainAplikasi
	 */
	public function __construct(
		DomainAplikasi $domainAplikasi, 
		ViewAplikasi $vw_aplikasi,
		TmAplikasi $tm_aplikasi,
		AplikasiDetail $aplikasi_detail
	) 
	{
		$this->domainAplikasi  = $domainAplikasi;
		$this->tm_aplikasi = $tm_aplikasi;
		$this->vw_aplikasi  = $vw_aplikasi;
		$this->aplikasi_detail = $aplikasi_detail;
	}

	/**
	 * Get's Domain Aplikasi data by
	 *
	 * @return mixed
	 */
	public function getDataBy(Request $request)
	{		
		$query = $this->domainAplikasi
					  ->select(DB::raw(''.$request->col.' as kode, '.$request->col.' as kode_nama'))
					  ->groupBy($request->col);
		return $query->get();
	}

	public function getDataAplikasi(Request $request)
	{		
		$query = $this->tm_aplikasi
		->with('layanan')
		->orderBy('nama_apl', 'asc')->active();
		if(isset($request->opd_id)){
			$query->where('opd_id',$request->opd_id);
		}
		return $query->get();
	}

	public function getAplikasiDetail(Request $request)
	{		
		$query = $this->aplikasi_detail
		->leftJoin('TR_OPD', 'tm_aplikasi_detail.opd_input_id', 'tr_opd.opd_id')
		->orderBy('apl_id', 'asc')->active();
		if(isset($request->apl_id)){
			$query->where('apl_id',$request->apl_id);
		}

		return DomainAplikasiDetailResources::collection($query->paginate($request->limit));
	}

	public function listData(Request $request)
	{
		$query = $this->vw_aplikasi
		->select('apl_id', 'nama_apl', 'raa_level_1', 'raa_level_2', 'raa_level_3', 'raa_level_4', 'app_ownership', 'app_external')
		->groupBy('apl_id', 'nama_apl', 'raa_level_1', 'raa_level_2', 'raa_level_3', 'raa_level_4', 'app_ownership','app_external')
		->orderBy('apl_id', 'desc');
		
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
			$query->whereRaw("((app_ownership='Pemilik' and opd_id='".$opd_id."') or (app_external is not null and opd_input_id='".$opd_id."'))");
		} else {
			return [];
		}
		return DomainAplikasiResources::collection($query->paginate($request->limit));
	}

	public function delete(Request $request)
	{
		$input 		= $request->all();
		$find = $this->vw_aplikasi->findBySlug($input['id']);
		$apl_id = $find->apl_id;

		$used_app_terhubung = TmInfrastrukturSplp::select('TM_INFRA_SPLP.nama', 'opd.nama_opd')
		->join('TR_OPD opd', 'TM_INFRA_SPLP.opd_id','opd.opd_id')
		->where('TM_INFRA_SPLP.app_terhubung', '=', $apl_id)
		->distinct();

		$used_app = TmInfrastrukturSplp::select('TM_INFRA_SPLP.nama', 'opd.nama_opd')
		->join('TR_OPD opd', 'TM_INFRA_SPLP.opd_id','opd.opd_id')
		->where('TM_INFRA_SPLP.app_dihubungkan', '=', $apl_id)
		->distinct()
		->union($used_app_terhubung)
		->get()->toArray();
		
		if ($used_app) {
			
			$hasil = ['type'=>'error_used',
				'message' => 'Aplikasi ini digunakan pada Domain SPLP, mohon mengubah keterkaitan aplikasi terlebih dahulu pada:',
				'errorMsg' => $used_app
			];

			return json_encode($hasil);
		}
		
		try{
			$user_id = auth()->user()->v_userid;
			$data = ['deleted_by' => $user_id,
					'deleted_at' => date('Y-m-d H:i:s')
					];
			$del = $this->tm_aplikasi
				->where('apl_id', $find->apl_id)
				->update($data);
			createLog(config('tables.master.tm_aplikasi'), 'DEL', collect($del)->sortKeys());

			$type 				= 'success';
			$message			= 'Data Domain Aplikasi Berhasil Dihapus	';
			$errorMsg			= '';
		}catch(\Throwable $t){
			$type 				= 'error';
			$message			= 'Data Domain Aplikasi Gagal Dihapus ';
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
		$before = $this->tm_aplikasi->find($input['apl_id']);
		
		if (!$before) {
			$type 				= 'error';
			$save 			= 'Data tidak ditemukan';
			$message			= 'Data Domain Aplikasi Gagal Disimpan.';
			$hasil = ['type'=>$type,
				  'message' => $message,
				  'save' => $save
				 ];
			return json_encode($hasil);
		}

		$find = $this->tm_aplikasi
			->where('nama_apl', '=', $input['nama_apl'])
			->where('apl_id', '<>', $input['apl_id'])->active()->first();

		if ($find) {
			$hasil = [
				'type' 				=> 'error',
				'save' 				=> 'Data Domain Aplikasi Gagal Disimpan',
				'message'			=> 'Aplikasi dengan nama '.$input['nama_apl'].' sudah ada.'
			];
			return json_encode($hasil);
		}

		DB::beginTransaction();
		try
		{
			$data = ['nama_apl' => $input['nama_apl'], 
				'raa_level_1' => $input['raa_level_1'], 
				'raa_level_2' => $input['raa_level_2'], 
				'raa_level_3' => $input['raa_level_3'],
				'raa_level_4' => $input['raa_level_4'], 
				'app_external' => $input['app_external'] && $input['app_ownership'] == 'User'? $input['app_external'] : '-',
				'jenis_akses' => $input['jenis_akses'],
				'url' => $input['url'],
				'license' => $input['license'],
				'prog_lang' => $input['prog_lang'],
				'dev_framework' => $input['dev_framework'],
				'database' => $input['database'],
				'unit_oper' => $input['unit_oper'],
				'unit_dev' => $input['unit_dev'], 
				'status_oper' => $input['status_oper'], 
				'dev_type' => $input['dev_type'], 
				'ots_name' => $input['ots_name'], 					
				'num_user_add' => $input['num_user_add'], 
				'num_user' => $input['num_user'], 
				'ram_need' => $input['ram_need'],
				'cpu_need' => $input['cpu_need'],
				'storage_need' => $input['storage_need'], 
				'dasar_hukum' => $input['dasar_hukum'],
				'unit_rel_ext' => $input['unit_rel_ext'],
				'kom_type' => $input['kom_type'],
				'frekuensi' => $input['frekuensi'],
				'dev_plan' => $input['dev_plan'],
				'proper' => $input['proper'],
				'jenis_tl' => $input['jenis_tl'],
				'deskripsi' => $input['deskripsi'],
				'fungsi' => $input['fungsi'],
				'rel_apl' => $input['rel_apl'],
				'rel_data' => $input['rel_data'],
				'domain_code' => 'DAA ' . $input['raa_level_4'],
				'updated_by' => $user_id,
				'updated_at' => date('Y-m-d H:i:s')
				];
			$updateData = $this->tm_aplikasi->find($input['apl_id']);
			$updateData->update($data);

			$save = $updateData;
			createLog(config('tables.master.tm_aplikasi'), 'UPD', [
				'before' => collect($before)->sortKeys(),
				'after' => collect($updateData)->sortKeys()
			]);

			
			$detail_before = $this->aplikasi_detail->find($input['detail']['id']);
			$detail_before->app_ownership = $input['app_ownership'];
			$detail_before->updated_at = date('Y-m-d H:i:s');
			$detail_before->updated_by = $user_id;
			$detail_before->save();

			createLog(config('tables.master.aplikasi_detail'), 'UPD', [
				'before' => collect($input['detail'])->sortKeys(),
				'after' => collect($detail_before)->sortKeys()
			]);

			$updateData->layanan()->sync($input['layanan']);
			$updateData->data()->sync($input['data']);
			$updateData->luaran()->sync($input['luaran']);

			AplikasiBasis::where('apl_id', '=', $input['apl_id'])->delete();
			foreach ($input['jenis_akses_2'] as $key => $value) {
				$url = '';
				if ($value == 'Web') {
					$url = $input['url_2_web'];
				} else if ($value == 'Mobile Web') {
					$url = $input['url_2_mobile_web'];
				}
				$data = [
					'apl_id'=> $input['apl_id'], 
					'basis_aplikasi' => $value,
					'url' => $url,
					'is_primary' => '0',
				];
				AplikasiBasis::create($data);
			}

			AplikasiBasis::create([
				'apl_id'=> $input['apl_id'], 
				'basis_aplikasi' => $input['jenis_akses'],
				'url' => $input['url'],
				'is_primary' => '1',
			]);

			$type 				= 'success';
			$save			= '';
			$message			= 'Data Domain Aplikasi Berhasil Disimpan.';
			DB::commit();
		}catch(\Throwable $t){
			$type 				= 'error';
			$save 			= $t->getMessage();
			$message			= 'Data Domain Aplikasi Gagal Disimpan.';
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

		$find = $this->tm_aplikasi->where('nama_apl', '=', $input['nama_apl'])->active()->first();
		if ($find) {
			$hasil = [
				'type' 				=> 'error',
				'save' 				=> 'Data Domain Aplikasi Gagal Disimpan',
				'message'			=> 'Aplikasi dengan nama '.$input['nama_apl'].' sudah ada.'
			];
			return json_encode($hasil);
		}
		DB::beginTransaction();
		
		try
		{		
			$max_id = $this->tm_aplikasi->max('apl_id');
			$new_apl_id = 'A'.(substr($max_id, 1) + 1);

			$data = ['apl_id' => $new_apl_id,
				'nama_apl' => $input['nama_apl'], 
				'raa_level_1' => $input['raa_level_1'], 
				'raa_level_2' => $input['raa_level_2'], 
				'raa_level_3' => $input['raa_level_3'],
				'raa_level_4' => $input['raa_level_4'], 
				'opd_id' => $input['opd_input'],
				'app_external' => $input['app_external'] ? $input['app_external'] : '-',
				'jenis_akses' => $input['jenis_akses'],
				'url' => $input['url'],
				'license' => $input['license'],
				'prog_lang' => $input['prog_lang'],
				'dev_framework' => $input['dev_framework'],
				'database' => $input['database'],
				'unit_oper' => $input['unit_oper'],
				'unit_dev' => $input['unit_dev'], 
				'status_oper' => $input['status_oper'], 
				'dev_type' => $input['dev_type'], 
				'ots_name' => $input['ots_name'], 					
				'num_user_add' => $input['num_user_add'], 
				'num_user' => $input['num_user'], 
				'ram_need' => $input['ram_need'],
				'cpu_need' => $input['cpu_need'],
				'storage_need' => $input['storage_need'], 
				'dasar_hukum' => $input['dasar_hukum'],
				'unit_rel_ext' => $input['unit_rel_ext'],
				'kom_type' => $input['kom_type'],
				'frekuensi' => $input['frekuensi'],
				'dev_plan' => $input['dev_plan'],
				'proper' => $input['proper'],
				'jenis_tl' => $input['jenis_tl'],
				'deskripsi' => $input['deskripsi'],
				'fungsi' => $input['fungsi'],
				'rel_apl' => $input['rel_apl'],
				'rel_data' => $input['rel_data'],
				'domain_code' => 'DAA ' . $input['raa_level_4'],
				'created_by' => $user_id,
				'created_at' => date('Y-m-d H:i:s')
				];

			$new_aplikasi = $this->tm_aplikasi::create($data);
			createLog(config('tables.master.tm_aplikasi'), 'INS', collect($new_aplikasi)->sortKeys());
			
			$max_detail_id = $this->aplikasi_detail->max('id');
			$new_apl_detail_id = ($max_detail_id + 1);

			$new_aplikasi_detail = $this->aplikasi_detail::create([
				'apl_id' => $new_apl_id,
				'app_ownership' => $input['app_ownership'],
				'opd_input_id' => $input['opd_input'],
				'created_by' => $user_id,
				'created_at' => date('Y-m-d H:i:s'),
				'id' => $new_apl_detail_id
			]);
			createLog(config('tables.master.aplikasi_detail'), 'INS', collect($new_aplikasi_detail)->sortKeys());
			foreach ($input['layanan'] as $key => $value) {
				$data = ['apl_id'=> $new_apl_id, 'layanan_id' => $value];
				$apl_layanan = AplikasiLayanan::create($data);
			}

			foreach ($input['data'] as $key => $value) {
				$data = ['apl_id'=> $new_apl_id, 'data_id' => $value];
				$apl_data = AplikasiData::create($data);
			}

			foreach ($input['luaran'] as $key => $value) {
				$data = ['apl_id'=> $new_apl_id, 'data_id' => $value];
				$apl_luaran = AplikasiLuaran::create($data);
			}

			foreach ($input['jenis_akses_2'] as $key => $value) {
				$url = '';
				if ($value == 'Web') {
					$url = $input['url_2_web'];
				} else if ($value == 'Mobile Web') {
					$url = $input['url_2_mobile_web'];
				}
				$data = [
					'apl_id'=> $new_apl_id, 
					'basis_aplikasi' => $value,
					'url' => $url,
					'is_primary' => '0',
				];
				AplikasiBasis::create($data);
			}

			AplikasiBasis::create([
				'apl_id'=> $new_apl_id, 
				'basis_aplikasi' => $input['jenis_akses'],
				'url' => $input['url'],
				'is_primary' => '1',
			]);


			$save = $new_aplikasi;
			$type 				= 'success';
			$message			= 'Data Domain Aplikasi Berhasil Disimpan';
			DB::commit();

		}catch(\Throwable $t){
			$type 				= 'error';
			$save 				= $t->getMessage();
			$message			= 'Data Domain Domain Aplikasi Gagal Disimpan';
			DB::rollBack();

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
		$view_aplikasi = $this->vw_aplikasi->findBySlug($id);
		if ($view_aplikasi) {
			$query = $this->tm_aplikasi
				->select(
					'tm_aplikasi.*', 
					'a.kode_nama as raa_level_1_nama',
					'b.kode_nama as raa_level_2_nama',
					'c.kode_nama as raa_level_3_nama',
					'd.kode_nama as raa_level_4_nama'
				)
				->with(
					'layanan', 'data', 'luaran', 'detail', 'luaran.opd', 'layanan.opd', 'data.opd',
					'unit_dev_opd', 'unit_oper_opd', 'aplikasi_basis'
				)
				->leftJoin('tr_ars_spbe a', function($join) {
					$join->on('tm_aplikasi.RAA_LEVEL_1', '=', 'a.kode')
					->where('a.kategori', '=', 'raa');
				})
				->leftJoin('tr_ars_spbe b', function($join) {
					$join->on('tm_aplikasi.RAA_LEVEL_2', '=', 'b.kode')
					->where('b.kategori', '=', 'raa');
				})
				->leftJoin('tr_ars_spbe c', function($join) {
					$join->on('tm_aplikasi.RAA_LEVEL_3', '=', 'c.kode')
					->where('c.kategori', '=', 'raa');
				})
				->leftJoin('tr_ars_spbe d', function($join) {
					$join->on('tm_aplikasi.RAA_LEVEL_4', '=', 'd.kode')
					->where('d.kategori', '=', 'raa');
				})
				->where('apl_id', $view_aplikasi->apl_id);
			return $query->first();
		} else {
			return null;
		}
	}
}
