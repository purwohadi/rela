<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\{DomainInfrastrukturCloud, TmInfraCloud, ArsSpbe, TmMetadataTerkait, Opd};
use App\Http\Resources\DomainInfrastrukturCloudResources;
use App\Repositories\Contracts\DomainInfrastrukturCloudRepositoryInterface;
use Illuminate\Support\Facades\DB;

class DomainInfrastrukturCloudRepository implements DomainInfrastrukturCloudRepositoryInterface
{
  protected $domain_infra_cloud;

  protected $columns = [
    'proses_id' => 'proses_id',
    'slug_path' => 'slug_path',
    'opd_id' => 'opd_id',
    'rai_level_1' => 'rai_level_1',
    'rai_level_2' => 'rai_level_2',
    'rai_level_3' => 'rai_level_3',
    'instansi' => 'instansi',
    'deskripsi' => 'deskripsi',
    'tipe' => 'tipe',
    'nama_owner' => 'nama_owner',
    'status_ownership' => 'status_ownership',
    'unit_dev' => 'unit_dev',
    'unit_oper' => 'unit_oper',
    'biaya' => 'biaya',
    'id_metadata_terkait' => 'id_metadata_terkait',
    'id' => 'id',
    'nama' => 'nama',
    'kode_l01' => 'kode_l01',
    'kode_l02' => 'kode_l02',
    'kode_l03' => 'kode_l03',
    'kode_l04' => 'kode_l04',
    'domain_code' => 'domain_code',
  ];


  /**
   * User constructor
   *
   * @param DomainInfrastrukturCloud $user_group
   */
  public function __construct(
    DomainInfrastrukturCloud $domain_infra_cloud,
    TmInfraCloud $TmInfraCloud,
    ArsSpbe $ArsSpbe,
    TmMetadataTerkait $TmMetadataTerkait,
    Opd $Opd
  ) {
    $this->domain_infra_cloud = $domain_infra_cloud;
    $this->TmInfraCloud = $TmInfraCloud;
    $this->ArsSpbe = $ArsSpbe;
    $this->TmMetadataTerkait = $TmMetadataTerkait;
    $this->Opd = $Opd;
  }

  /**
   * Get's all cloud.
   *
   * @return mixed
   */
  public function search(Request $request)
  {
    $query = $this->TmInfraCloud
            ->select(\DB::raw('TM_INFRA_CLOUD.ID, BIAYA, TM_INFRA_CLOUD.NAMA, DESKRIPSI, TR_OPD.NAMA_OPD, TM_INFRA_CLOUD.OPD_ID, STATUS_OWNERSHIP, UNIT_DEV, UNIT_OPER, a.KODE_NAMA AS "rai_level_1", b.KODE_NAMA AS "rai_level_2", c.KODE_NAMA AS "rai_level_3", TM_INFRA_CLOUD.domain_code, TM_INFRA_CLOUD.nama_owner'))
            ->leftJoin('tr_opd', 'tr_opd.opd_id', '=', \DB::raw('tm_infra_cloud.opd_id'))
            ->leftJoin(\DB::raw('tr_ars_spbe a'), 'a.kode', '=', \DB::raw("tm_infra_cloud.rai_level_1 AND a.kategori = 'rai'"))
            ->leftJoin(\DB::raw('tr_ars_spbe b'), 'b.kode', '=', \DB::raw("tm_infra_cloud.rai_level_2 AND b.kategori = 'rai'"))
            ->leftJoin(\DB::raw('tr_ars_spbe c'), 'c.kode', '=', \DB::raw("tm_infra_cloud.rai_level_3 AND c.kategori = 'rai'"))
            ->whereNull('deleted_at')->orderBy($this->columns['id'], 'desc');
            
    if ($request->has('search') && strlen(trim($request->search)) > 0) {
      $mapped = $this->columns;
      $query->where(function ($sql) use ($request, $mapped) {
        $idx = 0;
        foreach ($request->column_filters as $column) {
          $clause = $idx == 0 ? 'where' : 'orWhere';
          if ($column != 'featureaccess') {
            $sql->{$clause}(DB::raw("upper({$mapped[$column]})"), 'like', '%' . strtoupper($request->search) . '%');
          } else {
            $sql->orWhereHas('features', function ($q) use ($request) {
              $q->where(DB::raw("upper(v_name)"), 'like', '%' . strtoupper($request->search) . '%');
            });
          }
          ++$idx;
        }
      });
    }
    if (isset($request->opd_id)) {
      $query->where('TM_INFRA_CLOUD.opd_id', $request->opd_id);
    }
    return DomainInfrastrukturCloudResources::collection($query->paginate($request->limit));
  }

  public function get_data_metadata(Request $request)
  {

    $query = $this->domain_infra_cloud
      ->select(DB::raw("rab_level{$level} as rabl"))
      ->distinct()
      ->whereNotNull("rab_level{$level}")
      ->orderBy("rab_level{$level}");

    return $query->get();
  }

  public function get_list_instansi(Request $request)
  {

    $query = $this->domain_infra_cloud
      ->select(DB::raw("instansi"))
      ->distinct()
      ->orderBy("instansi");

    return $query->get();
  }

  public function get_list_tipe(Request $request)
  {

    $query = $this->domain_infra_cloud
      ->select(DB::raw("tipe"))
      ->distinct()
      ->whereNotNull("tipe")
      ->orderBy("tipe");

    return $query->get();
  }

  public function get_list_owner(Request $request)
  {

    $query = $this->domain_infra_cloud
      ->select(DB::raw("status_ownership"))
      ->distinct()
      ->whereNotNull("status_ownership")
      ->orderBy("status_ownership");

    return $query->get();
  }

  public function get_data_rail(Request $request, $level = 1)
  {

    $query = $this->domain_infra_cloud
      ->select(DB::raw("rai_level_{$level} as rail"))
      ->distinct()
      ->whereNotNull("rai_level_{$level}")
      ->orderBy("rai_level_{$level}");
    return $query->get();
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
      ->where("kode_nama", "LIKE", "%03.02%")
      ->orderBy("kode_nama");

    return $query->get();
  }

  public function get_data_rail3(Request $request, $rail3)
  {
    $query = $this->ArsSpbe
      ->select(DB::raw("kode_nama as rail"))
      ->where("kategori", "rai")
      ->where("tingkat", '3')
      ->where("kode_nama", "LIKE", $rail3.'%')
      ->orderBy("kode_nama");



    return $query->get();
  }

	/**
	 * Save a user
	 *
	 * @param array $input
	 */
	public function save(Request $request)
	{

		$user_id = auth()->user()->v_userid;
		$proses_id
		  = $this->TmInfraCloud
		  ->select(DB::raw("max(ID) as max_id"))
		  ->distinct()
		  ->first();
		$new_id = $proses_id->max_id + 1;
		try {
      if ($proses_id) {
        if ($request->selectedWaktu === 'Selamanya') {
          $jangka_waktu = $request->selectedWaktu;
        } else {
          $jangka_waktu = substr($request->selectDateFrom, 0, 3) . '-' . explode(' ', $request->selectDateFrom)[1] . ' s/d ' . substr($request->selectDateFromLast, 0, 3) . '-' . explode(' ', $request->selectDateFromLast)[1];
        }
        if ($request->own == 'Milik Sendiri') {
          $own_name = $request->own_name2;
        } else {
          if ($request->own == 'Milik Instansi Pemerintah Lain') {
            $own_name = $request->own_name3;
          } else {
            $own_name = $request->own_name;
          }
        }
				$query = $this->TmInfraCloud->create([
					'id' => $new_id,
					'rai_level_1' => explode(' ', $request->rail1)[0],
					'rai_level_2' => explode(' ', $request->rail2)[0],
					'rai_level_3' => explode(' ', $request->rail3)[0],
          'rai_level_4' => explode(' ', $request->rail4)[0],
					'opd_id' => $request->opd_id,
					'nama' => $request->name_gov,
					'deskripsi' => $request->desc_gov,
					'status_ownership' => $request->own,
					'nama_owner' => $own_name,
					'biaya' => $request->price,
					'jangka_waktu' => $jangka_waktu,
					'domain_code' => 'DAI ' . explode(' ', $request->rail3)[0] . '.' . $request->instansi[0] . ' ' . $request->name_gov,
					'unit_dev' => $request->unit_dev,
					'unit_oper' => $request->unit_opr,
					'created_by' => $user_id,
				]);
        createLog(config('tables.master.tm_infra_cloud'), 'INS', collect($query)->sortKeys());

        $data_komputasi = array();

        foreach ($request->id_metadata as $key => $value) {
          $data_komputasi = [
            'domain_name' => 'DOMAIN_INFRA_CLOUD',
            'domain_code' => 'DAI ' . explode(' ', $request->rail3)[0] . '.' . $request->instansi[0] . ' ' . $request->name_gov,
            'domain_terkait' => 'DOMAIN_INFRA_FASILITAS',
            'domain_terkait_code' => $value['kode'],
            'infra_id' => $new_id,
          ];
          TmMetadataTerkait::insert($data_komputasi);
          createLog(config('tables.master.tm_metadata_terkait'), 'INS', collect($data_komputasi)->sortKeys());
        }
			}
      
			$save = $query;
			$type 				= 'success';
			$message			= 'Data Domain Aplikasi Berhasil Disimpan';
      DB::commit();
    } catch (\Throwable $th) {
      $type 				= 'error';
			$save 				= $th->getMessage();
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
   * Get's a data infra cloud
   *
   * @param int
   * @param \Illuminate\Http\Request $request
   * @return collection
   */
  public function dataInfrastrukturCloud($id, Request $request)
  {
    DB::beginTransaction();
    $searchid = $this->TmInfraCloud->findbyslug($id);
    $query = $this->TmInfraCloud
            ->select('id',
             'rai_level_1',
             'rai_level_2',
             'rai_level_3',
             'nama',
             'deskripsi',
             'tr_opd.akronim as instansi',
             'domain_code',
             'nama_owner',
             'status_ownership',
             'unit_dev',
             'unit_oper',
             'biaya',
             'jangka_waktu')
            ->leftJoin('tr_opd', 'tr_opd.opd_id', '=', \DB::raw('tm_infra_cloud.opd_id'))
            ->where('id', $searchid->id);

    return $query->get();
  }

  /**
   * Deletes a domain cloud.
   *
   * @param string
   */
  public function delete($request)
  {
    try {
      $user_id   = auth()->user()->v_userid;
      $data = [
        'deleted_by' => $user_id,
        'deleted_at' => date('Y-m-d H:i:s')
      ];

      $del = $this->domain_infra_cloud
        ->where('id', $request->data['id'])
        ->update($data);

      createLog(config('tables.master.domain_proses'), 'DEL', collect($del)->sortKeys());
      return true;
    } catch (\Throwable $th) {
      return false;
    }
  }

  /**
   * Updates a cloud.
   *
   * @param array
   */
  public function update(Request $request, $id/*, array $data*/)
  {

    $user_id = auth()->user()->v_userid;
    $tm_infra_cloud = $this->TmInfraCloud->findBySlug($id);
    DB::beginTransaction();
    try {
      if ($tm_infra_cloud) {
        if ($request->selectedWaktu === 'Selamanya') {
          $jangka_waktu = $request->selectedWaktu;
        } else {
          $jangka_waktu = substr($request->selectDateFrom, 0, 3) . '-' . explode(' ', $request->selectDateFrom)[1] . ' s/d ' . substr($request->selectDateFromLast, 0, 3) . '-' . explode(' ', $request->selectDateFromLast)[1];
        }
        if ($request->own == 'Milik Sendiri') {
          $own_name = $request->own_name2;
        } else {
          if ($request->own == 'Milik Instansi Pemerintah Lain') {
            $own_name = $request->own_name3;
          } else {
            $own_name = $request->own_name;
          }
        }
        $data = [
          'rai_level_1' => explode(' ', $request->rail1)[0],
          'rai_level_2' => explode(' ', $request->rail2)[0],
          'rai_level_3' => explode(' ', $request->rail3)[0],
          'rai_level_4' => explode(' ', $request->rail4)[0],
          'opd_id' => $request->opd_id,
          'nama' => $request->name_gov,
          'deskripsi' => $request->desc_gov,
          'status_ownership' => $request->own,
          'nama_owner' => $own_name,
          'biaya' => $request->price,
          'jangka_waktu' => $jangka_waktu,
          'domain_code' => 'DAI ' . explode(' ', $request->rail3)[0] . '.' . $request->instansi[0] . ' ' . $request->name_gov,
          'unit_dev' => $request->unit_dev,
          'unit_oper' => $request->unit_opr,
          'updated_by' => $user_id,
          'updated_at' => date('Y-m-d H:i:s')
        ];
        $query_update = $this->TmInfraCloud
        ->where('id', $tm_infra_cloud->id)
        ->update($data);
        createLog(config('tables.master.tm_infra_cloud'), 'UPD', collect($query_update)->sortKeys());

        $this->TmMetadataTerkait
        ->where('infra_id', $tm_infra_cloud->id)
        ->where('domain_name', 'DOMAIN_INFRA_CLOUD')
        ->delete();

        $data_komputasi = array();

        foreach ($request->id_metadata as $key => $value) {
          $data_komputasi = [
            'domain_name' => 'DOMAIN_INFRA_CLOUD',
            'domain_code' => 'DAI ' . explode(' ', $request->rail3)[0] . '.' . $request->instansi[0] . ' ' . $request->name_gov,
            'domain_terkait' => 'DOMAIN_INFRA_FASILITAS',
            'domain_terkait_code' => $value['kode'],
            'infra_id' => $tm_infra_cloud->id,
          ];
          TmMetadataTerkait::insert($data_komputasi);
          createLog(config('tables.master.tm_metadata_terkait'), 'UPD', collect($data_komputasi)->sortKeys());
        }
      }
      createLog(config('tables.master.tm_infra_cloud'), 'UPD', collect($query_update)->sortKeys());
      
      $save = $query_update;
			$type 				= 'success';
			$message			= 'Data Domain Aplikasi Berhasil Disimpan';
      DB::commit();
    } catch (\Throwable $th) {
      $type 				= 'error';
			$save 				= $th->getMessage();
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
   * Get's a data domain Infra Storage
   *
   * @param int
   * @return collection
   */
  public function get_metadata_detail_data(Request $request, $id)
  {
    $query = $this->TmMetadataTerkait
      ->select(DB::raw("domain_terkait_code as kode_nama"))
      ->where("infra_id", $id)
      ->where("domain_name", 'DOMAIN_INFRA_CLOUD')
      ->where("domain_terkait", 'DOMAIN_INFRA_FASILITAS');

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
    $query = $this->Opd
      ->select(['opd_id', 'nama_opd', 'akronim'])
      ->where('jenis_instansi', 'OPD');
    if (isset($request->opd_id)) {
      $query->where('opd_id', $request->opd_id);
    }

    return $query->get();
  }
}
