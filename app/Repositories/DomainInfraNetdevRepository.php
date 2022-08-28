<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\{DomainInfraNetdev, TmInfraNetdev, ArsSpbe, Opd, TmMetadataTerkait};
use App\Repositories\Contracts\DomainInfraNetdevRepositoryInterface;

class DomainInfraNetdevRepository implements DomainInfraNetdevRepositoryInterface
{
	protected $columns = [
		'rai_level_1' => 'rai_level_1',
		'rai_level_2' => 'rai_level_2',
		'rai_level_3' => 'rai_level_3',
		'rai_level_4' => 'rai_level_4',
		'nama' => 'tm_infra_netdev.nama',
		'deskripsi' => 'deskripsi',
		'instansi_1' => 'e.akronim',
		'instansi_2' => 'f.akronim',
		'tipe_device' => 'tipe_device',
		'tipe_device_2' => 'tipe_device_2',
		'ownership' => 'ownership',
		'nama_owner' => 'nama_owner',
		'unit_pengelola' => 'unit_pengelola',
		'id_metadata_jip' => 'id_metadata_jip',
		'keterangan' => 'keterangan',
		'domain_code' => 'domain_code'
	  ];

	/**
	 * DomainInfraNetdevRepository constructor
	 *
	 * @param DomainInfraNetdev $domainInfraNetdev
	 */
	public function __construct(
    DomainInfraNetdev $domainInfraNetdev,
    TmInfraNetdev $TmInfraNetdev,
    ArsSpbe $ArsSpbe,
    Opd $Opd,
    TmMetadataTerkait $TmMetadataTerkait
  )
	{
		$this->domainInfraNetdev  = $domainInfraNetdev;
		$this->TmInfraNetdev  = $TmInfraNetdev;
		$this->ArsSpbe  = $ArsSpbe;
		$this->Opd  = $Opd;
		$this->TmMetadataTerkait  = $TmMetadataTerkait;
	}

	/**
	 * Get's Domain Infra netdev
	 *
	 * @return mixed
	 */
	public function dataIntraNetdev(Request $request)
	{
    // dd($request->opd_id);
		$query = $this->TmInfraNetdev
            ->select(DB::raw('tm_infra_netdev.id, a.KODE_NAMA as rai_level_1, b.KODE_NAMA as rai_level_2, c.KODE_NAMA as rai_level_3, d.KODE_NAMA as rai_level_4, tm_infra_netdev.nama, tm_infra_netdev.deskripsi, e.akronim as instansi_1, f.akronim as instansi_2, tm_infra_netdev.tipe_device, tm_infra_netdev.tipe_device_2, tm_infra_netdev.keterangan, tm_infra_netdev.domain_code'))
            ->leftJoin(\DB::raw('tr_ars_spbe a'), 'a.kode', '=', \DB::raw("tm_infra_netdev.rai_level_1 AND a.kategori = 'rai'"))
            ->leftJoin(\DB::raw('tr_ars_spbe b'), 'b.kode', '=', \DB::raw("tm_infra_netdev.rai_level_2 AND b.kategori = 'rai'"))
            ->leftJoin(\DB::raw('tr_ars_spbe c'), 'c.kode', '=', \DB::raw("tm_infra_netdev.rai_level_3 AND c.kategori = 'rai'"))
            ->leftJoin(\DB::raw('tr_ars_spbe d'), 'd.kode', '=', \DB::raw("tm_infra_netdev.rai_level_4 AND d.kategori = 'rai'"))
            ->leftJoin(DB::raw('tr_opd e'), 'e.opd_id', '=', \DB::raw("tm_infra_netdev.opd_id_1"))
            ->leftJoin(DB::raw('tr_opd f'), 'f.opd_id', '=', \DB::raw("tm_infra_netdev.opd_id_2"))
					  ->orderBy('tm_infra_netdev.id', 'desc')
					  ->where(DB::raw('tm_infra_netdev.deleted_at'), null);

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
      $query->where('tm_infra_netdev.opd_id_2', $request->opd_id);
    }
    // dd(getQueries($query));
		return $query->paginate($request->limit);
	}


	/**
	 * Save Data Domain Infra netdev.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function simpanDataDomainInfraNetdev($request){
    $input 		= $request->all();
		$user_id 	= auth()->user()->v_userid;
    $max_id = $this->TmInfraNetdev->max('id');
    $new_netdev_id = $max_id + 1;
    $nama_pemilik = '';
    if ($request->nama_owner != null) {
      $nama_pemilik = $request->nama_owner;
    } else {
      $nama_pemilik = $request->nama_owner2['akronim'];
    }
		try
		{
      $domain_code = 'DAI ' . $input['rai_level_4'];

			$data = [
            'id' => $new_netdev_id,
            'rai_level_1' => explode(' ', $input['rai_level_1']['rail'])[0],
            'rai_level_2' => explode(' ', $input['rai_level_2']['rail'])[0],
            'rai_level_3' => explode(' ', $input['rai_level_3']['rail'])[0],
            'rai_level_4' => explode(' ', $input['rai_level_4']['kode'])[0],
            'nama' => $input['nama'],
            'deskripsi' => $input['deskripsi'],
            'opd_id_1' => $input['instansi_1']['value'][0],
            'opd_id_2' => $input['instansi_2']['value'][0],
            'tipe_device' => $input['tipe_device']['kode'],
            'tipe_device_2' => $input['tipe_device_2'],
            'ownership' => $input['ownership']['kode'],
            'nama_owner' => $nama_pemilik,
            'unit_pengelola' => $input['unit_pengelola'],
            'keterangan' => $input['keterangan'],
            'id_netdev' => $domain_code,
            'domain_code' => $domain_code,
            'created_by' => $user_id,
            'created_at' => date('Y-m-d H:i:s')
					];
			$save 				= $this->TmInfraNetdev->create($data);
			createLog(config('tables.master.tm_infra_netdev'), 'INS', collect($save)->sortKeys());

      $data_jip = array();

      foreach ($request->id_metadata_jip as $key => $value) {
        $data_jip = [
          'domain_name' => 'DOMAIN_INFRA_NETDEV',
          'domain_code' => $domain_code,
          'domain_terkait' => 'DOMAIN_INFRA_JIP',
          'domain_terkait_code' => $value['id_infra_jip'],
          'infra_id' => $new_netdev_id,
        ];
        TmMetadataTerkait::insert($data_jip);
        createLog(config('tables.master.tm_metadata_terkait'), 'INS', collect($data_jip)->sortKeys());
      }

      $data_fasilitas = array();

      foreach ($request->id_metadata_fasilitas as $key => $value) {
        $data_fasilitas = [
          'domain_name' => 'DOMAIN_INFRA_NETDEV',
          'domain_code' => $domain_code,
          'domain_terkait' => 'DOMAIN_INFRA_FASILITAS',
          'domain_terkait_code' => $value['value'],
          'infra_id' => $new_netdev_id,
        ];
        TmMetadataTerkait::insert($data_fasilitas);
        createLog(config('tables.master.tm_metadata_terkait'), 'INS', collect($data_fasilitas)->sortKeys());
      }

			$type 				= 'success';
			$errorMsg			= '';
			$message			= 'Data Tambah Domain Infra Netdev Berhasil Disimpan';

		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Tambah Domain Infra Netdev Gagal Disimpan '.$errorMsg;
			$save 				= '';
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}

	/**
	 * Save Update Data Domain Infra netdev .
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateDataDomainInfraNetdev(Request $request){
		$input 		= $request->all();
		$user_id 	= auth()->user()->v_userid;

    $max_id = $this->TmInfraNetdev->max('id');
    $netdev_id = $max_id - 1;

    $nama_pemilik = '';
    if ($request->nama_owner != null) {
      $nama_pemilik = $request->nama_owner;
    } else {
      $nama_pemilik = $request->nama_owner2['akronim'];
    }

		DB::beginTransaction();
		try
		{
      $domain_code = 'DAI ' . $input['rai_level_4'];
			$data = [
              'rai_level_1' => explode(' ', $input['rai_level_1']['rail'])[0],
              'rai_level_2' => explode(' ', $input['rai_level_2']['rail'])[0],
              'rai_level_3' => explode(' ', $input['rai_level_3']['rail'])[0],
              'rai_level_4' => explode(' ', $input['rai_level_4']['kode'])[0],
              'nama' => $input['nama'],
              'deskripsi' => $input['deskripsi'],
              'opd_id_1' => $input['instansi_1']['value'][0],
              'opd_id_2' => $input['instansi_2']['value'][0],
              'tipe_device' => $input['tipe_device']['kode'],
              'tipe_device_2' => $input['tipe_device_2'],
              'ownership' => $input['ownership']['kode'],
              'nama_owner' => $nama_pemilik,
              'unit_pengelola' => $input['unit_pengelola'],
              'keterangan' => $input['keterangan'],
              'id_netdev' => $domain_code,
              'domain_code' => $domain_code,
              'updated_by' => $user_id,
              'updated_at' => date('Y-m-d H:i:s')
					];
      $update = $this->TmInfraNetdev
      ->where('id', $input['id'])
      ->update($data);

			createLog(config('tables.master.tm_infra_netdev'), 'UPD', collect($update)->sortKeys());

      $this->TmMetadataTerkait
      ->where('infra_id', $input['id'])
      ->where('domain_name', 'DOMAIN_INFRA_NETDEV')
      ->delete();

      $data_jip = array();

      foreach ($request->id_metadata_jip as $key => $value) {
        $data_jip = [
          'domain_name' => 'DOMAIN_INFRA_NETDEV',
          'domain_code' => $domain_code,
          'domain_terkait' => 'DOMAIN_INFRA_JIP',
          'domain_terkait_code' => $value['id_infra_jip'],
          'infra_id' => $input['id'],
        ];
        TmMetadataTerkait::insert($data_jip);
        createLog(config('tables.master.tm_metadata_terkait'), 'INS', collect($data_jip)->sortKeys());
      }

      $data_fasilitas = array();

      foreach ($request->id_metadata_fasilitas as $key => $value) {
        $data_fasilitas = [
          'domain_name' => 'DOMAIN_INFRA_NETDEV',
          'domain_code' => $domain_code,
          'domain_terkait' => 'DOMAIN_INFRA_FASILITAS',
          'domain_terkait_code' => $value['value'],
          'infra_id' => $input['id'],
        ];
        TmMetadataTerkait::insert($data_fasilitas);
        createLog(config('tables.master.tm_metadata_terkait'), 'INS', collect($data_fasilitas)->sortKeys());
      }

			$type 				= 'success';
			$errorMsg			= '';
			$message			= 'Data Domain Infra Netdev Berhasil Diubah';
			DB::commit();
		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Domain Infra Netdev Gagal Diubah '.$errorMsg;
			DB::rollBack();
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}

	/**
	 * Delete Data Domain Infra netdev.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deleteDataDomainInfraNetdev($request)
	{
		try{
			$user_id = auth()->user()->v_userid;
			$data 	 = [
              'deleted_by' => $user_id,
              'deleted_at' => date('Y-m-d H:i:s')
					   ];
			$del 	 = $this->TmInfraNetdev
							->where('id',$request->data['id'])
							->update($data);
			createLog(config('tables.master.tm_infra_netdev'), 'DEL', collect($del)->sortKeys());

			$type 				= 'success';
			$message			= 'Data Domain Infra Netdev Berhasil Dihapus	';
			$errorMsg			= '';
		}catch(\Throwable $t){
			$type 				= 'error';
			$errorMsg 			= $t->getMessage();
			$message			= 'Data Domain Infra Netdev Gagal Dihapus '.$errorMsg;
		}

		$hasil = ['type'=>$type,
				  'message' => $message,
				  'errorMsg' => $errorMsg
				 ];
		return json_encode($hasil);
	}

	/**
	 * Get's a data domain Infra netdev
	 *
	 * @param int
	 * @return collection
	 */
	public function searchIntraNetdev(Request $request)
	{
		return $this->TmInfraNetdev->findBySlug($request->id_netdev);
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
      ->where("kode_nama", "LIKE", "03.01%")
      ->orderBy("kode_nama");
    return $query->get();
  }

  public function get_data_rail3(Request $request)
  {

    $query = $this->ArsSpbe
      ->select(DB::raw("kode_nama as rail"))
      ->where("kategori", "rai")
      ->where("tingkat", '3')
      ->where("kode_nama", "LIKE", "03.01.03%")
      ->orderBy("kode_nama");
    return $query->get();
  }

  public function get_data_rail4(Request $request)
  {

    $query = $this->ArsSpbe
      ->select(DB::raw("kode_nama as rail"))
      ->where("kategori", "rai")
      ->where("tingkat", '4')
      ->where("kode_nama", "LIKE", "03.01.03%")
      ->orderBy("kode_nama");
    return $query->get();
  }

  public function get_data_opd(Request $request)
  {
    $query = $this->Opd->isOpd()->select(['opd_id', 'nama_opd', 'akronim'])->where('jenis_instansi', 'OPD');
    if (isset($request->opd_id)) {
      $query->where('opd_id', $request->opd_id);
    }
    return $query->get();
  }

  public function get_data_instansi1(Request $request)
  {

    $query = $this->Opd
      ->select(DB::raw("opd_id, nama_opd"))
      ->where("opd_id", "C01");
    return $query->get();
  }

  public function get_data_instansi2(Request $request)
  {

    $query = $this->Opd
      ->select(DB::raw("opd_id, akronim"))
      ->Orwhere("jenis_instansi", "OPD")
      ->Orwhere("jenis_instansi", "Cluster")
      ->Orwhere("jenis_instansi", "Pusat");
    return $query->get();
  }

  /**
   * Get's a data metadata jip
   *
   * @param int
   * @return collection
   */
  public function get_metadata_jip_data(Request $request, $id)
  {
    $query = $this->TmMetadataTerkait
      ->select(DB::raw("jip.id, jip.id_infra_jip, jip.nama_jip as kode_nama, domain_terkait_code as kode"))
      ->join('tm_infra_jip jip', 'domain_terkait_code', '=', DB::raw('TO_CHAR(jip.id)'))
      ->where("infra_id", $id)
      ->where("domain_name", 'DOMAIN_INFRA_NETDEV')
      ->where("domain_terkait", 'DOMAIN_INFRA_JIP');

    return $query->get();
  }

  /**
   * Get's a data metadata fasilitas
   *
   * @param int
   * @return collection
   */
  public function get_metadata_fasilitas_data(Request $request, $id)
  {
    $query = $this->TmMetadataTerkait
      ->select(DB::raw("domain_terkait_code as kode_nama"))
      ->where("infra_id", $id)
      ->where("domain_name", 'DOMAIN_INFRA_NETDEV')
      ->where("domain_terkait", 'DOMAIN_INFRA_FASILITAS');

    return $query->get();
  }
}
