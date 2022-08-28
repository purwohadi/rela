<?php

namespace App\Repositories;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\{User, UserGroup, DomainProses, ArsSpbe, TrKodeKepmen, TmProses, TmProsesTupoksi, VwDomainProses};
use Illuminate\Http\Request;
use App\Http\Resources\{DomainProsesBisnisResources, Rabl3MinResources, Rabl4MinResources, TmProsesTupoksiResources};
use App\Repositories\Contracts\DomainProsesBisnisRepositoryInterface;
use Illuminate\Support\Facades\{Log, File};
use DB;

class DomainProsesBisnisRepository implements DomainProsesBisnisRepositoryInterface
{
  protected $domain_proses;
  protected $user;
  protected $user_group;

  protected $columns = [
    'proses_id' => 'tm_proses.proses_id',
    'opd_id' => 'tm_proses.opd_id',
    'nama_opd' => 'tr_opd.nama_opd',
    'rab_level1' => 'rab_level1',
    'rab_level2' => 'rab_level2',
    'rab_level3' => 'rab_level3',
    'rab_level4' => 'rab_level4',
    'domain_code' => 'tm_proses.domain_code',
  ];


  /**
   * User constructor
   *
   * @param User $user
   * @param UserGroup $user_group
   * @param DomainProses $DomainProses
   * @param TmProses $TmProses
   * @param TmProsesTupoksi $TmProses
   * @param TrKodeKepmen $TrKodeKepmen
   * @param VwDomainProses $VwDomainProses
   */
  public function __construct(
    User $user,
    UserGroup $user_group,
    DomainProses $domain_proses,
    ArsSpbe $ArsSpbe,
    TmProses $TmProses,
    TmProsesTupoksi $TmProsesTupoksi,
    TrKodeKepmen $TrKodeKepmen,
    VwDomainProses $VwDomainProses
  ) {
    $this->user = $user;
    $this->user_group = $user_group;
    $this->domain_proses = $domain_proses;
    $this->ArsSpbe = $ArsSpbe;
    $this->TmProses = $TmProses;
    $this->TmProsesTupoksi = $TmProsesTupoksi;
    $this->TrKodeKepmen = $TrKodeKepmen;
    $this->VwDomainProses = $VwDomainProses;
  }
  /**
   * Get's all group.
   *
   * @return mixed
   */
  public function all()
  {
    return $this->group->all();
  }

  /**
   * Get's a group by it's ID
   *
   * @param int
   */
  public function all_by_status($status)
  {
    return $this->group->where('e_status_aktif', $status)->get();
  }

  /**
   * Get's a group by it's ID
   *
   * @param int
   */
  public function get($group_id)
  {
    return $this->group->find($group_id);
  }

  /**
   * Get's all users.
   *
   * @return mixed
   */
  public function search(Request $request)
  {
    // $subquery = '(SELECT DISTINCT(DOMAIN_CODE), PROSES_ID FROM TM_PROSES_TUPOKSI WHERE DELETED_AT IS NULL) B';

    // $query = $this->TmProses
    // ->select('tm_proses.proses_id as proses_id', 'vw_domain_proses.opd_id', 'vw_domain_proses.nama_opd as nama_opd', 'vw_domain_proses.rab_level1', 'vw_domain_proses.rab_level2', 'vw_domain_proses.rab_level3', 'vw_domain_proses.kode_lev4', 'vw_domain_proses.rab_level4', 'tm_proses.domain_code')
    // ->distinct('tm_proses.proses_id')
    // // ->leftJoin(\DB::raw($subquery), 'tm_proses.proses_id', '=', \DB::raw('B.proses_id'))
    // ->leftJoin('vw_domain_proses', 'vw_domain_proses.proses_id', '=', \DB::raw('tm_proses.proses_id'))
    // ->leftJoin('tr_opd', 'tr_opd.opd_id', '=', \DB::raw('tm_proses.opd_id'))
    // ->whereNull('tm_proses.deleted_at')
    // ->orderBy('tm_proses.proses_id', 'desc');

    // if ($request->has('search') && strlen(trim($request->search)) > 0) {
    //   $mapped = $this->columns;
    //   $query->where(function ($sql) use ($request, $mapped) {
    //     $idx = 0;
    //     foreach ($request->column_filters as $column) {
    //       $clause = $idx == 0 ? 'where' : 'orWhere';
    //       if ($column != 'featureaccess') {
    //         $sql->{$clause}(\DB::raw("upper({$mapped[$column]})"), 'like', '%' . strtoupper($request->search) . '%');
    //       } else {
    //         $sql->orWhereHas('features', function ($q) use ($request) {
    //           $q->where(\DB::raw("upper(tm_proses.domain_code)"), 'like', '%' . strtoupper($request->search) . '%');
    //         });
    //       }
    //       ++$idx;
    //     }
    //   });
    // }
    // if (isset($request->opd_id)) {
    //   $query->where('VW_DOMAIN_PROSES.opd_id', $request->opd_id);
    // }

    $query = $this->TmProses
      ->select('tm_proses.proses_id as proses_id', 'tm_proses.opd_id', 'tr_opd.nama_opd as nama_opd', 'a.KODE_NAMA as rab_level1', 'b.KODE_NAMA as rab_level2', 'c.KODE_NAMA as rab_level3', 'e.nomenklatur_urusan as rab_level4', 'e.kode_nomenklatur as kode_rab_level4', 'tm_proses.domain_code')
      ->distinct('tm_proses.proses_id')
      ->leftJoin('tr_opd', 'tr_opd.opd_id', '=', \DB::raw('tm_proses.opd_id'))
      ->leftJoin(\DB::raw('tr_ars_spbe a'), 'a.kode', '=', \DB::raw("TRIM(tm_proses.rab_level1) AND a.kategori = 'rab'"))
      ->leftJoin(\DB::raw('tr_ars_spbe b'), 'b.kode', '=', \DB::raw("TRIM(tm_proses.rab_level2) AND b.kategori = 'rab'"))
      ->leftJoin(\DB::raw('tr_ars_spbe c'), 'c.kode', '=', \DB::raw("TRIM(tm_proses.rab_level3) AND c.kategori = 'rab'"))
      ->leftJoin(\DB::raw('tr_ars_spbe d'), 'd.kode', '=', \DB::raw("TRIM(tm_proses.rab_level4) AND c.kategori = 'rab'"))
      ->leftJoin(\DB::raw('tr_kode_kepmen e'), 'e.kode_nomenklatur', '=', \DB::raw("TRIM(tm_proses.rab_level4)"))
      ->whereNull('tm_proses.deleted_at')
      ->orderBy('tm_proses.proses_id', 'desc');

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
              $q->where(\DB::raw("upper(tm_proses.domain_code)"), 'like', '%' . strtoupper($request->search) . '%');
            });
          }
          ++$idx;
        }
      });
    }
    if (isset($request->opd_id)) {
      $query->where('tm_proses.opd_id', $request->opd_id);
    }
    return DomainProsesBisnisResources::collection($query->paginate($request->limit));
  }

  public function get_data_rabl(Request $request, $level = 1)
  {

    $query = $this->ArsSpbe
      ->select(DB::raw("kode_nama as rabl"))
      ->where("kategori", "rab")
      ->where("tingkat", "{$level}")
      ->orderBy("kode_nama");

    return $query->get();
  }

  public function get_data_rabl_2(Request $request)
  {
    $kode_rabl = explode(' ', $request->kode_rabl)[0];
    $query = $this->ArsSpbe
      ->select(DB::raw("kode_nama as rabl2"))
      ->where('kategori', 'rab')
      ->where('tingkat', '2')
      ->orderBy("kode_nama");
    if ($request->kode_rabl != null) {
      $query->where(\DB::raw('substr(kode_nama, 0, 2)'), 'LIKE', $kode_rabl);
    }
    return $query->get();
  }

  public function get_data_rabl_3(Request $request)
  {
    $kode_rabl = explode(' ', $request->kode_rabl)[0];
    $like_rabl = $kode_rabl . '%';
    $query = $this->ArsSpbe
    ->select(DB::raw("kode_nama as rabl3"))
    ->where('kategori', 'rab')
    ->where('tingkat', '3')
      ->orderBy("kode_nama");
    if ($request->kode_rabl != null) {
      $query->where(\DB::raw('kode_nama'), 'LIKE', $like_rabl);
    }
    return $query->get();
  }

  public function get_data_program(Request $request)
  {
  $query = $this->TrKodeKepmen
    ->select(DB::raw("nomenklatur_urusan as program, kode_nomenklatur as kode_rabl, is_provinsi"))
    ->whereNotNull("program")
    ->whereNull("kegiatan")
    ->whereNull("sub_kegiatan")
    ->groupBy(DB::raw("nomenklatur_urusan, kode_nomenklatur, is_provinsi"))
    ->orderBy("kode_rabl");
    if ($request->opd_id === 'O46' || $request->opd_id === 'O51') {
      $query->where('is_provinsi', '1');
      $query->orWhere('is_provinsi', '0');
    } else {
      $query->where('is_provinsi', '1');
    }
    return $query->get();
  }

  public function get_data_rabl_4(Request $request)
  {
    $query = $this->TrKodeKepmen
      ->select(DB::raw("nomenklatur_urusan as rabl4, kode_nomenklatur as kode_rabl, is_provinsi"))
      ->whereNotNull("program")
      ->whereNotNull("kegiatan")
      ->whereNull("sub_kegiatan");
      if($request->kode_rabl != null){
        $query->where(\DB::raw('substr(kode_nomenklatur, 0, 7)'), 'LIKE', $request->kode_rabl);
      }
      if($request->opd_id === 'O46' || $request->opd_id === 'O51'){
        $query->where('is_provinsi', '1');
        $query->orWhere('is_provinsi', '0');
      }else{
        $query->where('is_provinsi', '1');
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
    $max_id = $this->TmProsesTupoksi->max('proses_id');
    $new_proses_id = substr($max_id, 1) + 1;
    $kode_rabl1 = explode(' ', $request->rabl1)[0];
    $kode_rabl2 = explode(' ', $request->rabl_2)[0];
    $kode_rabl3 = explode(' ', $request->rabl_3)[0];
    $kode_program = explode(' ', $request->program)[0];
    $kode_rabl4 = explode('- ', $request->rabl_4)[1];
    $final_rabl4 = explode(' ', $kode_rabl4)[0];

    $check_rabl4 = $this->TmProses->where('opd_id', $request->unit[0])->where('rab_level4', $final_rabl4)->whereNull('deleted_at');
    // dd(getQueries($check_rabl4));
    $count_rabl4 = $check_rabl4->get()->count();
    if($count_rabl4 == 0){
      DB::beginTransaction();
      try {
        $data = [
          'proses_id' => 'P' . $new_proses_id,
          'opd_id' => $request->unit[0],
          'rab_level1' => $kode_rabl1,
          'rab_level2' => $kode_rabl2,
          'rab_level3' => $kode_rabl3,
          'program' => $kode_program,
          'rab_level4' => $final_rabl4,
          'domain_code' => 'DAB ' . $kode_rabl2 . '.' . $final_rabl4,
          'created_at' => Carbon::now(),
          'created_by' => $user_id,
        ];
        TmProses::insert($data);
        createLog(config('tables.master.tm_proses'), 'INS', collect($data)->sortKeys());

        $data_tupoksi = array();

        foreach ($request->tupoksi as $key => $value) {
          $max_id = $this->TmProsesTupoksi->max('id');
          $new_id = intval($max_id) + 1;
          $data_tupoksi = [
            'id' => $new_id,
            'proses_id' => 'P' . $new_proses_id,
            'tupoksi' => $value['value'],
            'created_at' => Carbon::now(),
          ];
          TmProsesTupoksi::insert($data_tupoksi);
          createLog(config('tables.master.tm_proses_tupoksi'), 'INS', collect($data_tupoksi)->sortKeys());
          DB::commit();
        }
        $type         = 'success';
      } catch (\Throwable $th) {
        DB::rollBack();
        $type         = 'error';
      }
      $hasil = [
        'type' => $type
      ];
      return json_encode($hasil);
    }else{
      $hasil = [
        'type' => 'info'
      ];
      DB::rollBack();
      return json_encode($hasil);
    }
  }

  /**
   * Updates a group.
   *
   * @param array
   */
  public function update(Request $request, $proses_id/*, array $data*/)
  {
    $user_id = auth()->user()->v_userid;
    $max_id = $this->TmProsesTupoksi->max('proses_id');
    $kode_rabl1 = explode(' ', $request->rabl1)[0];
    $kode_rabl2 = explode(' ', $request->rabl_2)[0];
    $kode_rabl3 = explode(' ', $request->rabl_3)[0];
    $kode_program = explode(' ', $request->program)[0];
    $kode_rabl4 = explode('- ', $request->rabl_4)[1];
    $final_rabl4 = explode(' ', $kode_rabl4)[0];
    DB::beginTransaction();
    try {
      $data = [
        'proses_id' => $proses_id,
        'opd_id' => $request->unit[0],
        'rab_level1' => $kode_rabl1,
        'rab_level2' => $kode_rabl2,
        'rab_level3' => $kode_rabl3,
        'program' => $kode_program,
        'rab_level4' => $final_rabl4,
        'domain_code' => 'DAB ' . $kode_rabl2 . '.' . $final_rabl4,
        'updated_at' => Carbon::now(),
        'updated_by' => $user_id,
      ];

      $query_update = $this->TmProses
      ->where('proses_id', $proses_id)
      ->update($data);

      createLog(config('tables.master.tm_proses'), 'UPD', collect($query_update)->sortKeys());

      $this->TmProsesTupoksi
        ->where('proses_id', $proses_id)
        ->delete();

      $data_tupoksi = array();

      foreach ($request->tupoksi as $key => $value) {
        $max_id = $this->TmProsesTupoksi->max('id');
        $new_id = intval($max_id) + 1;
        $data_tupoksi = [
          'id' => $new_id,
          'proses_id' => $proses_id,
          'tupoksi' => $value['value'],
          'created_at' => Carbon::now(),
        ];
        TmProsesTupoksi::insert($data_tupoksi);
        createLog(config('tables.master.tm_proses_tupoksi'), 'UPD', collect($data_tupoksi)->sortKeys());
      }
      DB::commit();
      return true;
    }catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
  }

  /**
   * Deletes a domain proses.
   *
   * @param string
   */
  public function delete($request)
  {
    $check_proses_layanan = $this->TmProses
    ->select('tm_layanan.nama_layanan', 'tr_opd.nama_opd')
    ->leftJoin('tm_layanan_proses', 'tm_layanan_proses.proses_id', '=', \DB::raw('tm_proses.proses_id'))
    ->leftJoin('tm_layanan', 'tm_layanan.layanan_id', '=', \DB::raw('tm_layanan_proses.layanan_id'))
    ->leftJoin('tr_opd', 'tr_opd.opd_id', '=', \DB::raw('tm_proses.opd_id'))
    ->where('tm_proses.proses_id', $request->data['id'])
    ->whereNotNull('tm_layanan_proses.layanan_id')
    ->whereNull('tm_layanan.deleted_at');
    $count_proses_layanan = $check_proses_layanan->get()->count();

    $check_proses_info = $this->TmProses
    ->select('tm_informasi.nama_data', 'tr_opd.nama_opd')
    ->leftJoin('tm_proses_info', 'tm_proses_info.proses_id', '=', \DB::raw('tm_proses.proses_id'))
    ->leftJoin('tm_informasi', 'tm_informasi.info_id', '=', \DB::raw('tm_proses_info.info_id'))
    ->leftJoin('tr_opd', 'tr_opd.opd_id', '=', \DB::raw('tm_proses.opd_id'))
    ->where('tm_proses.proses_id', $request->data['id'])
    ->whereNotNull('tm_proses_info.id_info_proses')
    ->whereNull('tm_informasi.deleted_at');
    $count_proses_info = $check_proses_info->get()->count();

    if($count_proses_layanan == 0 && $count_proses_info == 0){
      try {
        $user_id   = auth()->user()->v_userid;
        $data = [
          'deleted_by' => $user_id,
          'deleted_at' => date('Y-m-d H:i:s')
        ];

        $this->TmProses
          ->where('proses_id', $request->data['id'])
          ->update($data);

        createLog(config('tables.master.tm_proses'), 'DEL', collect($data)->sortKeys());
        $type         = 'success';
        $message      = '';
      } catch (\Throwable $th) {
        $type         = 'error';
        $message      = '';
      }
      $hasil = [
        'type' => $type,
        'message' => $message
      ];
      return json_encode($hasil);
    }else{
      if($count_proses_layanan > 0 && $count_proses_info > 0){
        $isi_message = 'Mohon menghapus probis ini terlebih dahulu pada: <br><br>';
        $row = 0;
        for ($i = 0; $i < $count_proses_layanan; $i++) {
          $isi_message .= $i + 1 . '. ' . $check_proses_layanan->get()[$i]['nama_opd'] . ' - ' . $check_proses_layanan->get()[$i]['nama_layanan'] . '<br>';
          $row++;
        }
        for ($i = 0; $i < $count_proses_info; $i++) {
          $isi_message .= $row + 1 . '. ' . $check_proses_info->get()[$i]['nama_opd'] . ' - ' . $check_proses_info->get()[$i]['nama_data'] . '<br>';
          $row++;
        }
        $type = 'info';
        $message      = $isi_message;
      }elseif($count_proses_layanan >0){
        $isi_message = 'Mohon menghapus probis ini terlebih dahulu pada: <br><br>';
        for ($i=0; $i < $count_proses_layanan; $i++) {
          $isi_message .= $i+1 . '. ' . $check_proses_layanan->get()[$i]['nama_opd'] . ' - ' . $check_proses_layanan->get()[$i]['nama_layanan'] . '<br>';
        }
        $type = 'info';
        $message      = $isi_message;
      }elseif($count_proses_info > 0){
        $isi_message = 'Mohon menghapus probis ini terlebih dahulu pada: <br><br>';
        for ($i = 0; $i < $count_proses_info; $i++) {
          $isi_message .= $i + 1 . '. ' . $check_proses_info->get()[$i]['nama_opd'] . ' - ' . $check_proses_info->get()[$i]['nama_data'] . '<br>';
        }

        $type = 'info';
        $message      = $isi_message;
      }
      $hasil = [
        'type' => $type,
        'message' => $message
      ];
      return json_encode($hasil);

    }

  }

  /**
   * Get's a data proses bisnis
   *
   * @param int
   * @param \Illuminate\Http\Request $request
   * @return collection
   */
  public function dataProsesBisnis($proses_id, Request $request)
  {
    $query = $this->TmProses
      ->select('tm_proses.proses_id as proses_id', 'tm_proses.opd_id', 'tr_opd.nama_opd as nama_opd', 'a.KODE_NAMA as rab_level1', 'b.KODE_NAMA as rab_level2', 'c.KODE_NAMA as rab_level3', 'e.nomenklatur_urusan as rab_level4', 'e.kode_nomenklatur as kode_rab_level4', 'tm_proses.domain_code', 'f.is_provinsi', DB::raw("F.KODE_NOMENKLATUR || ' ' || F.NOMENKLATUR_URUSAN as program"))
      ->distinct('tm_proses.proses_id')
      ->leftJoin('tr_opd', 'tr_opd.opd_id', '=', \DB::raw('tm_proses.opd_id'))
      ->leftJoin(\DB::raw('tr_ars_spbe a'), 'a.kode', '=', \DB::raw("TRIM(tm_proses.rab_level1) AND a.kategori = 'rab'"))
      ->leftJoin(\DB::raw('tr_ars_spbe b'), 'b.kode', '=', \DB::raw("TRIM(tm_proses.rab_level2) AND b.kategori = 'rab'"))
      ->leftJoin(\DB::raw('tr_ars_spbe c'), 'c.kode', '=', \DB::raw("TRIM(tm_proses.rab_level3) AND c.kategori = 'rab'"))
      ->leftJoin(\DB::raw('tr_ars_spbe d'), 'd.kode', '=', \DB::raw("TRIM(tm_proses.rab_level4) AND c.kategori = 'rab'"))
      ->leftJoin(\DB::raw('tr_kode_kepmen e'), 'e.kode_nomenklatur', '=', \DB::raw("TRIM(tm_proses.rab_level4)"))
      ->leftJoin(\DB::raw('tr_kode_kepmen f'), 'f.kode_nomenklatur', '=', \DB::raw("TRIM(tm_proses.program)"))
      ->where('tm_proses.proses_id', $proses_id);
    return $query->get();
  }

  /**
   * Get's a data urusan
   *
   * @param int
   * @param \Illuminate\Http\Request $request
   * @return collection
   */
  public function get_urusan(Request $request)
  {
    $query = $this->TmProsesTupoksi
              ->select(\DB::raw('ROW_NUMBER() OVER(ORDER BY "TM_PROSES_TUPOKSI"."PROSES_ID" ASC) AS num_rows, TUPOKSI_DESC, TR_TUPOKSI.TUPOKSI, TR_TUPOKSI.TU_REF, TR_TUPOKSI.id_entitas, TR_TUPOKSI.nama_unit'))
              ->leftJoin("tr_tupoksi", \DB::raw("REPLACE(TR_TUPOKSI.TU_REF, ' ', '')"), "=", \DB::raw("REPLACE(tm_proses_tupoksi.tupoksi, ' ', '')"))
              ->orderBy('tm_proses_tupoksi.proses_id', 'asc');
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
                        $q->where(\DB::raw("upper(tr_proses_tupoksi.tupoksi_desc)"), 'like', '%' . strtoupper($request->search) . '%');
                      });
                    }
                    ++$idx;
                  }
                });

              }
    if ($request->has('proses_id')) {
      $query->where('tm_proses_tupoksi.proses_id', $request->proses_id);
    }
    return TmProsesTupoksiResources::collection($query->paginate($request->limit));
  }
}
