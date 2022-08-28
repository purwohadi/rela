<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\{DomainInfraStorage, ArsSpbe, TmInfrastrukturSplp, TmMetadataTerkait, TmInfraStorage, Opd};
use App\Repositories\Contracts\DomainInfraStorageRepositoryInterface;

class DomainInfraStorageRepository implements DomainInfraStorageRepositoryInterface
{
	protected $columns = [
    'id' => 'id',
		'rai_level_1' => 'rai_level_1',
		'rai_level_2' => 'rai_level_2',
		'rai_level_3' => 'rai_level_3',
		'rai_level_4' => 'rai_level_4',
		'nama' => 'nama',
		'deskripsi' => 'deskripsi',
		'instansi' => 'tr_opd.akronim',
		'data_used' => 'data_used',
		'domain_code' => 'domain_code'
	  ];

  /**
   * DomainInfraStorageRepository constructor
   *
   * @param DomainInfraStorage $domainInfraStorage
   * @param ArsSpbe $ArsSpbe
   * @param TmInfrastrukturSplp $TmInfrastrukturSplp
   * @param TmMetadataTerkait $TmMetadataTerkait
   * @param Opd $Opd
   */
	public function __construct(DomainInfraStorage $domainInfraStorage, ArsSpbe $ArsSpbe, TmInfrastrukturSplp $TmInfrastrukturSplp, TmMetadataTerkait $TmMetadataTerkait, TmInfraStorage $TmInfraStorage, Opd $Opd)
	{
		$this->domainInfraStorage  = $domainInfraStorage;
		$this->ArsSpbe  = $ArsSpbe;
		$this->TmInfrastrukturSplp  = $TmInfrastrukturSplp;
		$this->TmMetadataTerkait  = $TmMetadataTerkait;
		$this->TmInfraStorage  = $TmInfraStorage;
		$this->Opd  = $Opd;
	}

	/**
	 * Get's Domain Infra Storage
	 *
	 * @return mixed
	 */
	public function dataIntraStorage(Request $request)
	{
		$query = $this->TmInfraStorage
            ->select(DB::raw('tm_infra_storage.opd_id, tm_infra_storage.id, a.KODE_NAMA as rai_level_1, b.KODE_NAMA as rai_level_2, c.KODE_NAMA as rai_level_3, d.KODE_NAMA as rai_level_4, tm_infra_storage.nama, tm_infra_storage.deskripsi, e.akronim as instansi, tm_infra_storage.data_used, tm_infra_storage.domain_code'))
            ->leftJoin(\DB::raw('tr_ars_spbe a'), 'a.kode', '=', \DB::raw("TRIM(tm_infra_storage.rai_level_1) AND a.kategori = 'rai'"))
            ->leftJoin(\DB::raw('tr_ars_spbe b'), 'b.kode', '=', \DB::raw("TRIM(tm_infra_storage.rai_level_2) AND b.kategori = 'rai'"))
            ->leftJoin(\DB::raw('tr_ars_spbe c'), 'c.kode', '=', \DB::raw("TRIM(tm_infra_storage.rai_level_3) AND c.kategori = 'rai'"))
            ->leftJoin(\DB::raw('tr_ars_spbe d'), 'd.kode', '=', \DB::raw("TRIM(tm_infra_storage.rai_level_4) AND d.kategori = 'rai'"))
            ->leftJoin(DB::raw('tr_opd e'), 'e.opd_id', '=', \DB::raw("tm_infra_storage.opd_id"))
					  ->orderBy('id', 'desc')
					  ->whereNull('deleted_at');

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
    if (isset($request->opd_id)) {
      $query->where('tm_infra_storage.opd_id', $request->opd_id);
    }
		return $query->paginate($request->limit);
	}


	/**
	 * Save Data Domain Infra Storage.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainInfraStorage($request)
  {
    $user_id = auth()->user()->v_userid;
    $max_id = $this->TmInfraStorage->max('id');
    $new_storage_id = $max_id + 1;
    if ($request->ownership['kode'] == 'Milik Sendiri') {
      $own_name = $request->own_name2['value'][1];
    } else {
      if ($request->ownership['kode'] == 'Milik Instansi Pemerintah Lain') {
        $own_name = $request->own_name3['value'][1];
      } else {
        $own_name = $request->nama_owner;
      }
    }
		$input 		= $request->all();
		try
		{
			$data = [
          'id' => $new_storage_id,
          'nama' => $input['nama'],
          'opd_id' => $input['instansi']['value'][0],
          'rai_level_1' => explode(' ', $input['rai_level_1']['rail'])[0],
          'rai_level_2' => explode(' ', $input['rai_level_2']['rail'])[0],
          'rai_level_3' => explode(' ', $input['rai_level_3']['rail'])[0],
          'rai_level_4' => explode(' ', $input['rai_level_4']['kode_nama'])[0],
          'deskripsi' => $input['deskripsi'],
          'nama_owner' => $own_name,
          'ownership' => $input['ownership']['kode'],
          'unit_pengelola' => $input['unit_pengelola'],
          'lokasi' => $input['lokasi']['kode'],
          'software_used' => $input['software_used']['kode'],
          'kapasitas_penyimpanan' => $input['kapasitas_penyimpanan'],
          'data_used' => $input['data_used'],
          'domain_code' => 'DAI ' . explode(' ', $input['rai_level_4']['kode_nama'])[0],
          'created_by' => $user_id,
          'created_at' => date('Y-m-d H:i:s')
        ];
			$save 				= $this->TmInfraStorage->create($data);
			createLog(config('tables.master.tm_infra_storage'), 'INS', collect($save)->sortKeys());

      $data_keamanan = array();

      foreach ($request->id_metadata_keamanan as $key => $value) {
        $data_keamanan = [
          'domain_name' => 'DOMAIN_INFRA_STORAGE',
          'domain_code' => 'DAI ' . explode(' ', $input['rai_level_4']['kode_nama'])[0],
          'domain_terkait' => 'DOMAIN_INFRA_NETDEV',
          'domain_terkait_code' => $value['kode_nama'],
          'infra_id' => $new_storage_id,
        ];
        TmMetadataTerkait::insert($data_keamanan);
        createLog(config('tables.master.tm_metadata_terkait'), 'INS', collect($data_keamanan)->sortKeys());
      }

      $data_splp = array();

      foreach ($request->id_metadata_splp as $key => $value) {
        $data_splp = [
          'domain_name' => 'DOMAIN_INFRA_STORAGE',
          'domain_code' => 'DAI ' . explode(' ', $input['rai_level_4']['kode_nama'])[0],
          'domain_terkait' => 'DOMAIN_INFRA_SPLP',
          'domain_terkait_code' => $value['kode_nama'],
          'infra_id' => $new_storage_id,
        ];
        TmMetadataTerkait::insert($data_splp);
        createLog(config('tables.master.tm_metadata_terkait'), 'INS', collect($data_splp)->sortKeys());
      }

			$type 				= 'success';
			$errorMsg			= '';
			$message			= 'Data Tambah Domain Infra Storage Berhasil Disimpan';

		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Tambah Domain Infra Storage Gagal Disimpan '.$errorMsg;
			$save 				= '';
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}

	/**
	 * Save Update Data Domain Infra Storage .
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainInfraStorage( $request){
    $user_id 	= auth()->user()->v_userid;
    if ($request->ownership['kode'] == 'Milik Sendiri') {
      $own_name = $request->own_name2['value'][1];
    } else {
      if ($request->ownership['kode'] == 'Milik Instansi Pemerintah Lain') {
        $own_name = $request->own_name3['value'][1];
      } else {
        $own_name = $request->nama_owner;
      }
    }
		$input 		= $request->all();


    $type         = 'success';
    $errorMsg      = '';
    $message      = 'Data Domain Infra Storage Berhasil Diubah';

		DB::beginTransaction();
		try
		{
			$data = [
          'nama' => $input['nama'],
          'opd_id' => $input['instansi']['value'][0],
          'rai_level_1' => explode(' ', $input['rai_level_1']['rail'])[0],
          'rai_level_2' => explode(' ', $input['rai_level_2']['rail'])[0],
          'rai_level_3' => explode(' ', $input['rai_level_3']['rail'])[0],
          'rai_level_4' => explode(' ', $input['rai_level_4']['kode_nama'])[0],
          'deskripsi' => $input['deskripsi'],
          'nama_owner' => $own_name,
          'ownership' => $input['ownership']['kode'],
          'unit_pengelola' => $input['unit_pengelola'],
          'lokasi' => $input['lokasi']['kode'],
          'software_used' => $input['software_used']['kode'],
          'kapasitas_penyimpanan' => $input['kapasitas_penyimpanan'],
          'data_used' => $input['data_used'],
          'domain_code' => 'DAI ' . explode(' ', $input['rai_level_4']['kode_nama'])[0],
					 'updated_by' => $user_id,
					 'updated_at' => date('Y-m-d H:i:s')
					];

			$post = $this->TmInfraStorage
						->where('id',$input['id'])
						->update($data);

			createLog(config('tables.master.tm_infra_storage'), 'UPD', collect($post)->sortKeys());

      $this->TmMetadataTerkait
      ->where('infra_id', $input['id'])
      ->where('domain_name', 'DOMAIN_INFRA_STORAGE')
      ->delete();

      $data_keamanan = array();

      foreach ($request->id_metadata_keamanan as $key => $value) {
        $data_keamanan = [
          'domain_name' => 'DOMAIN_INFRA_STORAGE',
          'domain_code' => 'DAI ' . explode(' ', $input['rai_level_4']['kode_nama'])[0],
          'domain_terkait' => 'DOMAIN_INFRA_NETDEV',
          'domain_terkait_code' => $value['kode_nama'],
          'infra_id' => $input['id'],
        ];
        TmMetadataTerkait::insert($data_keamanan);
        createLog(config('tables.master.tm_metadata_terkait'), 'INS', collect($data_keamanan)->sortKeys());
      }

      $data_splp = array();

      foreach ($request->id_metadata_splp as $key => $value) {
        $data_splp = [
          'domain_name' => 'DOMAIN_INFRA_STORAGE',
          'domain_code' => 'DAI ' . explode(' ', $input['rai_level_4']['kode_nama'])[0],
          'domain_terkait' => 'DOMAIN_INFRA_SPLP',
          'domain_terkait_code' => $value['kode_nama'],
          'infra_id' => $input['id'],
        ];
        TmMetadataTerkait::insert($data_splp);
        createLog(config('tables.master.tm_metadata_terkait'), 'INS', collect($data_splp)->sortKeys());
      }

			$type 				= 'success';
			$errorMsg			= '';
			$message			= 'Data Domain Infra Storage Berhasil Diubah';
			DB::commit();
		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Domain Infra Storage Gagal Diubah '.$errorMsg;
			DB::rollBack();
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}

	/**
	 * Delete Data Domain Infra Storage.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainInfraStorage($request)
	{
		try{
			$user_id 	= auth()->user()->v_userid;
			$data = [
        'deleted_by' => $user_id,
        'deleted_at' => date('Y-m-d H:i:s')
      ];
			$del = $this->TmInfraStorage
						->where('id',$request->data['id'])
						->update($data);
			createLog(config('tables.master.tm_infra_storage'), 'DEL', collect($del)->sortKeys());

			$type 				= 'success';
			$message			= 'Data Domain Infra Storage Berhasil Dihapus	';
			$errorMsg			= '';
		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Domain Infra Storage Gagal Dihapus '.$errorMsg;
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}

	/**
	 * Get's a data domain Infra Storage
	 *
	 * @param int
	 * @return collection
	 */
	public function searchIntraStorage(Request $request)
	{

		return $this->TmInfraStorage->findBySlug($request->id_storage);
	}

  public function get_data_rail1(Request $request)
  {

    $query = $this->ArsSpbe
      ->select(DB::raw("kode_nama as rail"))
      ->where("kategori", "rai")
      ->where("tingkat", '1')
      ->where("kode_nama", "LIKE", "%03%")
      ->orderBy("kode_nama");

    return $query->get();
  }

  public function get_data_rail2(Request $request)
  {

    $query = $this->ArsSpbe
      ->select(DB::raw("kode_nama as rail"))
      ->where("kategori", "rai")
      ->where("tingkat", '2')
      ->where("kode_nama", "LIKE", "%03.01%")
      ->orderBy("kode_nama");

    return $query->get();
  }

  public function get_data_rail3(Request $request)
  {

    $query = $this->ArsSpbe
      ->select(DB::raw("kode_nama as rail"))
      ->where("kategori", "rai")
      ->where("tingkat", '3')
      ->where("kode_nama", "LIKE", "%03.01.02%")
      ->orderBy("kode_nama");

    return $query->get();
  }

  public function get_data_rail4(Request $request)
  {

    $query = $this->ArsSpbe
      ->select(DB::raw("kode, kode_nama as rail"))
      ->where("kategori", "rai")
      ->where("tingkat", '4')
      ->where("kode_nama", "LIKE", "%03.01.02%")
      ->orderBy("kode");

    return $query->get();
  }

  /**
   * Get's a data domain Infra Storage
   *
   * @param int
   * @return collection
   */
  public function getMetadataKeamanan(Request $request)
  {
    // $query = $this->TmMetadataTerkait
    //   ->select(DB::raw("domain_terkait_code as kode_nama"))
    //   ->where("infra_id", $request->id_storage)
    //   ->where("domain_terkait", 'DOMAIN_INFRA_NETDEV');
    $query = $this->TmMetadataTerkait
    ->select(DB::raw("TM_METADATA_TERKAIT.domain_terkait_code||' - '||TRIM(TR_ARS_SPBE.NAMA) AS kode_nama"))
    ->leftJoin(DB::raw('TR_ARS_SPBE'), 'TR_ARS_SPBE.KODE', '=', DB::raw('SUBSTR(TM_METADATA_TERKAIT.domain_terkait_code, 5, 11)'))
    ->whereNotNull("DOMAIN_CODE")
    ->where("infra_id", $request->id_storage)
    ->where("domain_name", 'DOMAIN_INFRA_STORAGE')
    ->where("domain_terkait", 'DOMAIN_INFRA_NETDEV')
    ->groupBy(DB::raw("domain_terkait_code, TM_METADATA_TERKAIT.domain_terkait_code||' - '||TRIM(TR_ARS_SPBE.NAMA)"));

    return $query->get();
  }

  /**
   * Get's a data domain Infra Storage
   *
   * @param int
   * @return collection
   */
  public function getMetadataSplp(Request $request)
  {
    // $query = $this->TmMetadataTerkait
    //   ->select(DB::raw("domain_terkait_code as kode_nama"))
    //   ->where("infra_id", $request->id_storage)
    //   ->where("domain_terkait", 'DOMAIN_INFRA_SPLP');
    $query = $this->TmMetadataTerkait
    ->select(DB::raw("TM_METADATA_TERKAIT.domain_terkait_code||' - '||TRIM(TR_ARS_SPBE.NAMA) AS kode_nama"))
    ->leftJoin(DB::raw('TR_ARS_SPBE'), 'TR_ARS_SPBE.KODE', '=', DB::raw('SUBSTR(TM_METADATA_TERKAIT.domain_terkait_code, 5, 11)'))
    ->whereNotNull("DOMAIN_CODE")
    ->where("infra_id", $request->id_storage)
    ->where("domain_name", 'DOMAIN_INFRA_STORAGE')
    ->where("domain_terkait", 'DOMAIN_INFRA_SPLP')
    ->where("TR_ARS_SPBE.kategori", 'raa')
    ->groupBy(DB::raw("domain_terkait_code, TM_METADATA_TERKAIT.domain_terkait_code||' - '||TRIM(TR_ARS_SPBE.NAMA)"));
    // dd(getQueries($query));
    return $query->get();
  }

  /**
   * Get's a data domain Infra Storage
   *
   * @param int
   * @return collection
   */
  public function get_instansi(Request $request)
  {
    $query = $this->Opd
      ->select(DB::raw("akronim", 'opd_id'))
      ->where('opd_id', $request->opd_id);

    return $query->get();
  }
}
