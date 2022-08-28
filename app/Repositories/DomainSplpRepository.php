<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\{DomainInfrastrukturSplp, TmInfrastrukturSplp, ArsSpbe, Apps, DomainInfraJip, Opd, InfraJip, TmMetadataTerkait};
use App\Http\Resources\DomainInfrastrukturSplpResources;
use App\Repositories\Contracts\DomainSplpRepositoryInterface;
use DB;

class DomainSplpRepository implements DomainSplpRepositoryInterface
{
  protected $domain_infra_splp;

  protected $columns = [
    'slug_path' => 'slug_path',
    'opd_id' => 'opd_id',
    'rai_level_1' => 'rai_level_1',
    'rai_level_2' => 'rai_level_2',
    'rai_level_3' => 'rai_level_3',
    'rai_level_4' => 'rai_level_4',
    'nama' => 'nama',
    'instansi' => 'instansi',
    'deskripsi' => 'deskripsi',
    'jenis' => 'jenis',
    'app_dihubungkan' => 'app_dihubungkan',
    'app_terhubung' => 'app_terhubung',
    'domain_code' => 'domain_code',
    'id' => 'id'
  ];


  /**
   * User constructor
   *
   * @param DomainInfrastrukturSplp $user_group
   */
  public function __construct(
    DomainInfrastrukturSplp $domain_infra_splp,
    TmInfrastrukturSplp $TmInfrastrukturSplp,
    ArsSpbe $ArsSpbe,
    Apps $Apps,
    DomainInfraJip $DomainInfraJip,
    Opd $Opd,
    InfraJip $InfraJip,
    TmMetadataTerkait $TmMetadataTerkait
  ) {
    $this->domain_infra_splp = $domain_infra_splp;
    $this->TmInfrastrukturSplp = $TmInfrastrukturSplp;
    $this->ArsSpbe = $ArsSpbe;
    $this->Apps = $Apps;
    $this->DomainInfraJip = $DomainInfraJip;
    $this->OPD = $Opd;
    $this->InfraJip = $InfraJip;
    $this->TmMetadataTerkait = $TmMetadataTerkait;
  }

  /**
   * Get's all splp.
   *
   * @return mixed
   */
  public function search(Request $request)
  {
    $query = $this->TmInfrastrukturSplp
            ->select(\DB::raw('tm_infra_splp.id, tm_infra_splp.opd_id, a.KODE_NAMA as rai_level_1, b.KODE_NAMA as rai_level_2, c.KODE_NAMA as rai_level_3, d.KODE_NAMA as rai_level_4, tm_infra_splp.nama, tm_infra_splp.deskripsi, tm_infra_splp.jenis, e.NAMA_APL as app_terhubung, f.NAMA_APL as app_dihubungkan, tm_infra_splp.domain_code'))
            ->leftJoin(\DB::raw('tr_ars_spbe a'), 'a.kode', '=', \DB::raw("tm_infra_splp.rai_level_1 AND a.kategori = 'rai'"))
            ->leftJoin(\DB::raw('tr_ars_spbe b'), 'b.kode', '=', \DB::raw("tm_infra_splp.rai_level_2 AND b.kategori = 'rai'"))
            ->leftJoin(\DB::raw('tr_ars_spbe c'), 'c.kode', '=', \DB::raw("tm_infra_splp.rai_level_3 AND c.kategori = 'rai'"))
            ->leftJoin(\DB::raw('tr_ars_spbe d'), 'd.kode', '=', \DB::raw("tm_infra_splp.rai_level_4 AND d.kategori = 'rai'"))
            ->leftJoin(\DB::raw('domain_aplikasi e'), 'e.apl_id', '=', \DB::raw("tm_infra_splp.app_terhubung"))
            ->leftJoin(\DB::raw('domain_aplikasi f'), 'f.apl_id', '=', \DB::raw("tm_infra_splp.app_dihubungkan"))
            ->whereNull('tm_infra_splp.deleted_at')
            ->groupBy(\DB::raw(
              'tm_infra_splp.id, tm_infra_splp.opd_id, a.KODE_NAMA, b.KODE_NAMA, c.KODE_NAMA, d.KODE_NAMA, tm_infra_splp.nama, tm_infra_splp.deskripsi, tm_infra_splp.jenis, e.NAMA_APL, f.NAMA_APL, tm_infra_splp.domain_code'
            ))
            ->orderBy('tm_infra_splp.id', 'desc');

    if ($request->has('search') && strlen(trim($request->search)) > 0) {
      $mapped = $this->columns;
      $query->where(function ($sql) use ($request, $mapped) {
        $idx = 0;
        foreach ($request->column_filters as $column) {
          $clause = $idx == 0 ? 'where' : 'orWhere';
          if ($column != 'featureaccess') {
            $sql->{$clause}(\DB::raw("upper({$mapped[$column]})"), 'like', '%' . strtoupper($request->search) . '%');
          } else {
            $sql->orWhereHas('features', function ($q) use ($request) {
              $q->where(\DB::raw("upper(v_name)"), 'like', '%' . strtoupper($request->search) . '%');
            });
          }
          ++$idx;
        }
      });
    }
    if (isset($request->opd_id)) {
      $query->where('tm_infra_splp.opd_id', $request->opd_id);
    }
    // dd(getQueries($query));
    return DomainInfrastrukturSplpResources::collection($query->paginate($request->limit));
  }

  public function get_list_app(Request $request)
  {

    $query = $this->Apps
      ->select(DB::raw("tm_aplikasi.nama_apl, tm_aplikasi.apl_id, tr_opd.akronim"))
      ->leftJoin('tr_opd', 'tr_opd.opd_id', '=', \DB::raw('tm_aplikasi.opd_id'))
      ->distinct()
      ->orderBy("nama_apl");

    return $query->get();
  }

  public function get_list_app_connected(Request $request)
  {

    $query = $this->Apps
      ->select(DB::raw("nama_apl, apl_id"))
      ->distinct()
      ->orderBy("nama_apl");



    return $query->get();
  }

  public function get_list_jenis(Request $request)
  {

    $query = $this->domain_infra_splp
      ->select(DB::raw("jenis"))
      ->distinct()
      ->where('jenis', 'NOT LIKE', '%Pengubung%')
      ->whereNotNull("jenis")
      ->orderBy("jenis");



    return $query->get();
  }

  public function get_list_jip(Request $request)
  {

    $query = $this->DomainInfraJip
      ->select(DB::raw("rai_level_4"))
      ->distinct()
      ->whereNotNull("rai_level_4")
      ->orderBy("rai_level_4");



    return $query->get();
  }

  public function get_data_rail1(Request $request)
  {

    $query = $this->ArsSpbe
      ->select(DB::raw("kode_nama as rail"))
      ->where("kategori", "rai")
      ->where("tingkat", '1')
      ->where("kode_nama", "LIKE", "%02%")
      ->orderBy("kode_nama");


    return $query->get();
  }

  public function get_data_rail2(Request $request)
  {

    $query = $this->ArsSpbe
      ->select(DB::raw("kode_nama as rail"))
      ->where("kategori", "rai")
      ->where("tingkat", '2')
      ->where("kode_nama", "LIKE", "%02.02%")
      ->orderBy("kode_nama");


    return $query->get();
  }

  public function get_data_rail3(Request $request)
  {

    $query = $this->ArsSpbe
      ->select(DB::raw("kode_nama as rail"))
      ->where("kategori", "rai")
      ->where("tingkat", '3')
      ->where("kode_nama", "LIKE", "02.02%")
      ->orderBy("kode_nama");


    return $query->get();
  }

  public function get_data_rail4(Request $request)
  {
    $rail = explode(' ', $request->rail)[0];
    $rail3 = substr($rail, 4, 8);
    $query = $this->ArsSpbe
      ->select(DB::raw("kode_nama as rail"))
      ->where("kategori", "rai")
      ->where("tingkat", '4')
      ->orderBy("kode_nama");
      if ($request->rail != null) {
      $query->where(DB::raw("substr(kode_nama, 0, 8)"), "LIKE", "%" . $rail . "%");
      }

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
    $id
      = $this->TmInfrastrukturSplp
      ->select(DB::raw("max(ID) as max_id"))
      ->distinct()
      ->first();
    $new_id = $id->max_id + 1;

    $rail1 = explode(' ', $request->rail1)[0];
    $rail2 = explode(' ', $request->rail2)[0];
    $rail3 = explode(' ', $request->rail3)[0];
    $rail4 = explode(' ', $request->rail4)[0];
    // $instansi = count($split_instansi) > 1 ? $split_instansi[1] : $split_instansi[1];
    DB::beginTransaction();
    try {
      if ($new_id) {
        if($request->own == 'Milik Sendiri'){
          $own_name = $request->own_name2;
        }else{
          if ($request->own == 'Milik Instansi Pemerintah Lain') {
            $own_name = $request->own_name3;
          }
          else{
            $own_name = $request->own_name;
          }
        }
        $data = [
          'id' => $new_id,
          'rai_level_1' => $rail1,
          'rai_level_2' => $rail2,
          'rai_level_3' => $rail3,
          'rai_level_4' => $rail4,
          'nama' => $request->name_splp,
          'opd_id' => $request->instansi[0],
          'deskripsi' => $request->desc_splp,
          'jenis' => $request->jenis,
          'ownership' => $request->own,
          'nama_owner' => $own_name,
          'app_dihubungkan' => explode(' ', $request->id_app_connect)[0],
          'app_terhubung' => explode(' ', $request->id_app_connected)[0],
          'domain_code' => 'DAI ' . $rail4,
          'created_at' => date('Y-m-d H:i:s'),
          'created_by' => $user_id,
        ];
        $save = $this->TmInfrastrukturSplp->create($data);
      }
      createLog(config('tables.master.tm_infra_splp'), 'INS', collect($save)->sortKeys());

      $data_jip = array();

      foreach ($request->id_metadata as $key => $value) {
        $data_jip = [
          'domain_name' => 'DOMAIN_INFRA_SPLP',
          'domain_code' => 'DAI ' . $rail4,
          'domain_terkait' => 'DOMAIN_INFRA_JIP',
          'domain_terkait_code' => $value['value'],
          'infra_id' => $new_id,
        ];
        TmMetadataTerkait::insert($data_jip);
        createLog(config('tables.master.tm_metadata_terkait'), 'INS', collect($data_jip)->sortKeys());
      }

      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
  }

  /**
   * Get's a data infra cloud
   *
   * @param int
   * @param \Illuminate\Http\Request $request
   * @return collection
   */
  public function dataInfrastrukturSplp($id, Request $request)
  {
    $searchid = $this->TmInfrastrukturSplp->findBySlug($id);
    $query = $this->TmInfrastrukturSplp
      ->select(
        'tm_infra_splp.id',
        'a.KODE_NAMA as rai_level_1',
        'b.KODE_NAMA as rai_level_2',
        'c.KODE_NAMA as rai_level_3',
        'd.KODE_NAMA as rai_level_4',
        'tm_infra_splp.nama',
        'tm_infra_splp.deskripsi',
        'tr_opd.akronim as instansi',
        'tm_infra_splp.domain_code',
        'tm_infra_splp.nama_owner',
        'tm_infra_splp.ownership',
        'tm_infra_splp.jenis',
        'e.NAMA_APL as app_terhubung',
        'f.NAMA_APL as app_dihubungkan'
      )
      ->leftJoin('tr_opd', 'tr_opd.opd_id', '=', \DB::raw('tm_infra_splp.opd_id'))
      ->leftJoin(\DB::raw('tr_ars_spbe a'), 'a.kode', '=', \DB::raw("tm_infra_splp.rai_level_1 AND a.kategori = 'rai'"))
      ->leftJoin(\DB::raw('tr_ars_spbe b'), 'b.kode', '=', \DB::raw("tm_infra_splp.rai_level_2 AND b.kategori = 'rai'"))
      ->leftJoin(\DB::raw('tr_ars_spbe c'), 'c.kode', '=', \DB::raw("tm_infra_splp.rai_level_3 AND c.kategori = 'rai'"))
      ->leftJoin(\DB::raw('tr_ars_spbe d'), 'd.kode', '=', \DB::raw("tm_infra_splp.rai_level_4 AND d.kategori = 'rai'"))
      ->leftJoin(\DB::raw('domain_aplikasi e'), 'e.apl_id', '=', \DB::raw("tm_infra_splp.app_terhubung"))
      ->leftJoin(\DB::raw('domain_aplikasi f'), 'f.apl_id', '=', \DB::raw("tm_infra_splp.app_dihubungkan"))
      ->where('tm_infra_splp.id', $searchid->id);
    return $query->get();
  }

  /**
   * Deletes a domain infra splp.
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

      $del = $this->TmInfrastrukturSplp
        ->where('id', $request->data['id'])
        ->update($data);

      createLog(config('tables.master.tm_infra_splp'), 'DEL', collect($del)->sortKeys());
      return true;
    } catch (\Throwable $th) {
      return false;
    }
  }

  /**
   * Updates a splp.
   *
   * @param array
   */
  public function update(Request $request, $id)
  {
    $user_id = auth()->user()->v_userid;
    $searchid = $this->TmInfrastrukturSplp->findBySlug($id);

    $rail1 = explode(' ', $request->rail1)[0];
    $rail2 = explode(' ', $request->rail2)[0];
    $rail3 = explode(' ', $request->rail3)[0];
    $rail4 = explode(' ', $request->rail4)[0];

    DB::beginTransaction();
    try {
      if ($searchid) {
        if ($request->own == 'Milik Sendiri') {
          $own_name = $request->own_name2;
        } else {
          if ($request->own == 'Milik Instansi Pemerintah Lain') {
            $own_name = $request->own_name3;
          } else {
            $own_name = $request->own_name;
          }
        }
        $data_update = [
          'rai_level_1' => $rail1,
          'rai_level_2' => $rail2,
          'rai_level_3' => $rail3,
          'rai_level_4' => $rail4,
          'nama' => $request->name_splp,
          'opd_id' => $request->instansi[0],
          'deskripsi' => $request->desc_splp,
          'jenis' => $request->jenis,
          'ownership' => $request->own,
          'nama_owner' => $own_name,
          'app_dihubungkan' => explode(' ', $request->id_app_connect)[0],
          'app_terhubung' => explode(' ', $request->id_app_connected)[0],
          'domain_code' => 'DAI ' . $rail4,
          'updated_at' => date('Y-m-d H:i:s'),
          'updated_by' => $user_id,
        ];
        $query_update = $this->TmInfrastrukturSplp
        ->where('id', $searchid->id)
        ->update($data_update);
      }
      createLog(config('tables.master.tm_infra_splp'), 'UPD', collect($query_update)->sortKeys());

      $this->TmMetadataTerkait
        ->where('infra_id', $searchid->id)
        ->where('domain_name', 'DOMAIN_INFRA_SPLP')
        ->delete();

      $data_komputasi = array();

      foreach ($request->id_metadata as $key => $value) {
        $data_komputasi = [
          'domain_name' => 'DOMAIN_INFRA_SPLP',
          'domain_code' => 'DAI ' . $rail4,
          'domain_terkait' => 'DOMAIN_INFRA_JIP',
          'domain_terkait_code' => $value['value'],
          'infra_id' => $searchid->id,
        ];
        TmMetadataTerkait::insert($data_komputasi);
        createLog(config('tables.master.tm_metadata_terkait'), 'UPD', collect($data_komputasi)->sortKeys());
      }
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
  }

  public function get_data_instansi(Request $request)
  {
    $query = $this->OPD
      ->select(DB::raw("opd_id, akronim"))
      ->where('jenis_instansi', 'OPD')
      ->where('opd_id', '<>', $request->opd_id);
      // ->orWhere('jenis_instansi', 'Pusat');

    return $query->get();
  }

  public function get_data_metadata(Request $request)
  {
    $query = $this->InfraJip
      ->select(DB::raw("TM_INFRA_JIP.DOMAIN_CODE AS kode, TM_INFRA_JIP.DOMAIN_CODE||' - '||TRIM(TR_ARS_SPBE.NAMA) AS kode_nama"))
      ->leftJoin(DB::raw('TR_ARS_SPBE'), 'TR_ARS_SPBE.KODE', '=', DB::raw('TM_INFRA_JIP.RAI_LEVEL_4'))
      ->whereNotNull("DOMAIN_CODE")
      ->whereNull("DELETED_AT")
      ->groupBy(DB::raw("DOMAIN_CODE, TM_INFRA_JIP.DOMAIN_CODE||' - '||TRIM(TR_ARS_SPBE.NAMA)"));
    return $query->get();
  }

  /**
   * Get's a data metadata jip
   *
   * @param int
   * @return collection
   */
  public function get_metadata_detail_data(Request $request, $id)
  {
    $query = $this->TmMetadataTerkait
      ->select(DB::raw("TM_METADATA_TERKAIT.domain_terkait_code||' - '||TRIM(TR_ARS_SPBE.NAMA) AS kode_nama"))
      ->leftJoin(DB::raw('TR_ARS_SPBE'), 'TR_ARS_SPBE.KODE', '=', DB::raw('SUBSTR(TM_METADATA_TERKAIT.domain_terkait_code, 5, 11)'))
      ->whereNotNull("DOMAIN_CODE")
      ->where("infra_id", $id)
      ->where("domain_name", 'DOMAIN_INFRA_SPLP')
      ->where("domain_terkait", 'DOMAIN_INFRA_JIP')
      ->groupBy(DB::raw("domain_terkait_code, TM_METADATA_TERKAIT.domain_terkait_code||' - '||TRIM(TR_ARS_SPBE.NAMA)"));
    return $query->get();
  }
}
