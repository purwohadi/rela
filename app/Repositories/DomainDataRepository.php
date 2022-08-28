<?php

namespace App\Repositories;

use Illuminate\Support\Carbon;
use App\Models\{TmInformasi, TmInformasiDetail, ArsSpbe, TmInformasiInteroperabilitas, TmProses, TmProsesInfo};
use Illuminate\Http\Request;
use App\Http\Resources\{DomainDataResources, DetailDataInformasiResources, TmProbisDetailResources};
use App\Repositories\Contracts\DomainDataRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Diskominfotik\QueryFilter\Query\Where;

class DomainDataRepository implements DomainDataRepositoryInterface
{
  protected $tm_informasi, $tm_informasi_detail;

  protected $columns = [
    'slug_path' => 'slug_path',
    'info_id' => 'tm_informasi.info_id',
    'opd_id' => 'tm_informasi.opd_id',
    'nama_data' => 'tm_informasi.nama_data',
    'nama_opd' => 'tr_opd.nama_opd',
    'rad_level1_nama' => 'a.kode_nama',
    'rad_level2_nama' => 'b.kode_nama'
  ];


  /**
   * User constructor
   *
   * @param TmInformasi $tm_informasi
   * @param TmInformasiDetail $tm_informasi_detail
   */
  public function __construct(
    TmInformasi $tm_informasi,
    ArsSpbe $ArsSpbe,
    TmProses $TmProses,
    TmProsesInfo $TmProsesInfo,
    TmInformasiDetail $tm_informasi_detail
  ) {
    $this->tm_informasi = $tm_informasi;
    $this->ArsSpbe = $ArsSpbe;
    $this->TmProses = $TmProses;
    $this->TmProsesInfo = $TmProsesInfo;
    $this->tm_informasi_detail = $tm_informasi_detail;
  }
  /**
   * Get's all users.
   *
   * @return mixed
   */
  public function search(Request $request)
  {

    $query = $this->tm_informasi
      ->select(
        'tm_informasi.info_id',
        'tm_informasi.rad_level_1',
        'a.kode_nama as rad_level_1_nama',
        'b.kode_nama as rad_level_2_nama',
        'c.kode_nama as rad_level_3_nama',
        'tm_informasi.rad_level_2',
        'tm_informasi.rad_level_3',
        'tr_opd.nama_opd as nama_opd',
        'tm_informasi.nama_data as nama_data'
      )
      ->leftJoin('tr_opd', 'tr_opd.opd_id', '=', \DB::raw('tm_informasi.opd_id'))
      ->leftJoin('tr_ars_spbe a', function($join) {
        $join->on('tm_informasi.RAD_LEVEL_1', '=', 'a.kode')
        ->where('a.kategori', '=', 'rad');
      })
      ->leftJoin('tr_ars_spbe b', function($join) {
        $join->on('tm_informasi.RAD_LEVEL_2', '=', 'b.kode')
        ->where('b.kategori', '=', 'rad');
      })
      ->leftJoin('tr_ars_spbe c', function($join) {
        $join->on('tm_informasi.RAD_LEVEL_3', '=', 'c.kode')
        ->where('c.kategori', '=', 'rad');
      })
      ->orderBy('tm_informasi.info_id', 'desc')
      ->whereNull('tm_informasi.deleted_at');
      // dd(($request->opd_id));

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
              $q->where(\DB::raw("upper(tm_informasi.nama_data)"), 'like', '%' . strtoupper($request->search) . '%');
            });
          }
          ++$idx;
        }
      });
    }
    if (isset($request->opd_id)) {
      $query->where('tm_informasi.opd_id', $request->opd_id);
    } else {
      return [];
    }
    return DomainDataResources::collection($query->paginate($request->limit));
  }

  public function get_data_radl1(Request $request)
  {

    $query = $this->ArsSpbe
      ->select("kode_nama", "kode")
      ->where("kategori", "rad")
      ->where("tingkat", "1")
      ->orderBy("kode_nama");

    return $query->get();
  }

  public function get_data_radl2(Request $request)
  {
    
    $query = $this->ArsSpbe
      ->select("kode_nama", "kode")
      ->where("kategori", "rad")
      ->where("tingkat", "2")
      ->orderBy("kode_nama");
      
    if ($request->kode) {
      $query->where('kode', 'like', $request->kode.'%');
    }
    
    return $query->get();
  }

  public function get_data_radl3(Request $request)
  {
    
    $query = $this->ArsSpbe
      ->select("kode_nama", "kode")
      ->where("kategori", "rad")
      ->where("tingkat", "3")
      ->orderBy("kode_nama");
      
    if ($request->kode) {
      $query->where('kode', 'like', $request->kode.'%');
    }
    
    return $query->get();
  }

  public function get_data_probis_terkait(Request $request)
  {

    $query = $this->TmProses
      ->select("proses_id", "rab_level4 as probis", "kepmen.nomenklatur_urusan as nomenklatur")
      ->leftJoin('tr_kode_kepmen kepmen', 'kepmen.kode_nomenklatur', '=', 'tm_proses.rab_level4')
      ->orderBy("rab_level4");
      
      if ($request->opd_id) {
        $query->where("opd_id", $request->opd_id);
      }
    return $query->get();
  }

  /**
   * Save a data
   *
   * @param array $input
   */
  public function save(Request $request)
  {
    $user_id = auth()->user()->v_userid;
    $max_id = $this->tm_informasi->max('info_id');
    $new_info_id = substr($max_id, 1) + 1;
    
    $find = $this->tm_informasi->where('nama_data', '=', $request->data_name)->active()->first();
    if ($find) {
      $hasil = [
        'type' 				=> 'error',
        'save' 				=> 'Data Domain Data Gagal Disimpan',
        'message'			=>  'Data dengan nama '. $request->data_name .' sudah ada.'
      ];
      return json_encode($hasil);
    }
    DB::beginTransaction();

    try {
      $data = [
        'info_id' => 'I' . $new_info_id,
        'opd_id' => $request->opd_id,
        'rad_level_1' => $request->radl1,
        'rad_level_2' => $request->radl2,
        'rad_level_3' => $request->radl3,
        'nama_data' => $request->data_name,
        'created_at' => Carbon::now(),
        'created_by' => $user_id,
        'domain_code' => 'DAD ' . $request->radl3 . '.' . $request->opd_id,
      ];

      TmInformasi::insert($data);
      createLog(config('tables.master.tm_informasi'), 'INS', collect($data)->sortKeys());

      $max_id_detail = $this->tm_informasi_detail->max('id');
      $new_id = intval($max_id_detail) + 1;

      $data_detail = [
        'info_id' => 'I' . $new_info_id,
        'nama_data' => $request->data_name,
        'uraian_data' => $request->desc_data,
        'komponen_data' => $request->comp_data,
        'tujuan_data' => $request->dest_data,
        'sifat_data' => $request->prop_data,
        'jenis_data1' => $request->type_data1,
        'jenis_data2' => $request->type_data2,
        'jenis_lain' => $request->type_data2_other,
        'format_struct' => $request->format_struct,
        'format_unstruct' => $request->format_unstruct,
        'format_lain' => $request->format,
        'dampak_risiko' => $request->resiko,
        'level_data' => $request->level_data,
        'metode' => $request->pengambilan_data,
        'jumlah_record' => $request->jml_record,
        'validitas' => $request->validitas_data,
        'data_owner' => $request->penanggung_jawab,
        'id' => $new_id,
        'created_by' => $user_id,
        'created_at' => Carbon::now(),
      ];

      TmInformasiDetail::insert($data_detail);
      createLog(config('tables.master.tm_informasi_detail'), 'INS', collect($data_detail)->sortKeys());

      $proses_bisnis = array();

      foreach ($request->probis_terkait as $key => $value) {
        $max_id_info_proses = $this->TmProsesInfo->max('id_info_proses');
        $new_id_info = intval($max_id_info_proses) + 1;
        $proses_bisnis = [
          'id_info_proses' => $new_id_info,
          'info_id' => 'I' . $new_info_id,
          'proses_id' => $value['proses_id'],
          'created_at' => Carbon::now(),
          'created_by' => $user_id,
        ];
        TmProsesInfo::insert($proses_bisnis);
      }

      foreach ($request->interoperabilitas as $key => $value) {
				$data = ['info_detail_id'=> $new_id, 'data_id' => $value['info_id']];
				TmInformasiInteroperabilitas::create($data);
			}

      DB::commit();
			$save = $data_detail;
			$type 				= 'success';
			$message			= 'Data Domain Data Berhasil Disimpan';

    } catch (\Throwable $th) {
      $type 				= 'error';
			$save 				= $th->getMessage();
			$message			= 'Data Domain Domain Data Gagal Disimpan';
      
      DB::rollBack();
    }

    $hasil = ['type'=>$type,
				  'message' => $message,
				  'save' => $save
				 ];
		return json_encode($hasil);
  }

  /**
   * Get's a data info detil
   *
   * @param int
   * @param \Illuminate\Http\Request $request
   * @return collection
   */
  public function dataInformasi($info_id, Request $request)
  {
    // dd($info_id);
    $query = $this->tm_informasi
      ->select(
        'tm_informasi.rad_level_1',
        'tm_informasi.rad_level_2',
        'tm_informasi.rad_level_3',
        'a.kode_nama as rad_level_1_nama',
        'b.kode_nama as rad_level_2_nama',
        'c.kode_nama as rad_level_3_nama',
        'tr_opd.nama_opd as nama_opd',
        'tm_informasi.nama_data as nama_data'
      )      
      ->where('info_id', $info_id)
      ->leftJoin('tr_opd', 'tr_opd.opd_id', '=', \DB::raw('tm_informasi.opd_id'))
      ->leftJoin('tr_ars_spbe a', function($join) {
        $join->on('tm_informasi.RAD_LEVEL_1', '=', 'a.kode')
        ->where('a.kategori', '=', 'rad');
      })
      ->leftJoin('tr_ars_spbe b', function($join) {
        $join->on('tm_informasi.RAD_LEVEL_2', '=', 'b.kode')
        ->where('b.kategori', '=', 'rad');
      })
      ->leftJoin('tr_ars_spbe c', function($join) {
        $join->on('tm_informasi.RAD_LEVEL_3', '=', 'c.kode')
        ->where('c.kategori', '=', 'rad');
      })
      ->first();
    // dd(getQueries($query));
    return $query;
  }

  /**
   * Get's a data urusan
   *
   * @param int
   * @param \Illuminate\Http\Request $request
   * @return collection
   */
  public function get_detail_data(Request $request)
  {
    $query = $this->tm_informasi_detail
      ->select(\DB::raw('uraian_data, tujuan_data, sifat_data, komponen_data, jenis_data1, jenis_data2, data_owner, id'))
      ->orderBy('info_id', 'desc')
      ->whereNull('deleted_at');
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
              $q->where(\DB::raw("upper(uraian_data)"), 'like', '%' . strtoupper($request->search) . '%');
            });
          }
          ++$idx;
        }
      });
    }
    if ($request->has('info_id')) {
      $query->where('info_id', $request->info_id);
    }
    // dd(getQueries($query));
    return DetailDataInformasiResources::collection($query->paginate($request->limit));
  }

  /**
   * Updates a data.
   *
   * @param array
   */
  public function update(Request $request, $info_id)
  {
    // dd($request->data_name);
    $user_id = auth()->user()->v_userid;
    $tm_informasi = $this->tm_informasi
      ->where('info_id', $info_id)
      ->first();

    $find = $this->tm_informasi->where('nama_data', '=', $request->data_name)
        ->where('info_id', '<>', $info_id)
        ->active()->first();
    
		if ($find) {
			$hasil = [
				'type' 				=> 'error',
				'save' 				=> 'Data Domain Data Gagal Disimpan',
				'message'			=> 'Data dengan nama '. $request->data_name .' sudah ada'
			];
			return json_encode($hasil);
		}
    DB::beginTransaction();

    try {
      if ($tm_informasi) {
        $data = [
          'nama_data' => $request->data_name,
          'updated_at' => Carbon::now(),
          'updated_by' => $user_id,
          'rad_level_1' =>$request->radl1,
          'rad_level_2' => $request->radl2,
          'rad_level_3' => $request->radl3,
          'domain_code' => 'DAD ' . $request->radl3 . '.' . $request->opd_id,
        ];

        $tm_informasi->update($data);
        createLog(config('tables.master.tm_informasi'), 'UPD', collect($data)->sortKeys());

        $proses_info = $this->TmProsesInfo->where('info_id', $info_id);
        $proses_info->delete();
        foreach ($request->probis_terkait as $key => $value) {
          $max_id_info_proses = $this->TmProsesInfo->max('id_info_proses');
          $new_id_info = intval($max_id_info_proses) + 1;
          $proses_bisnis = [
            'id_info_proses' => $new_id_info,
            'info_id' => $info_id,
            'proses_id' => $value['proses_id'],
            'created_at' => Carbon::now(),
            'created_by' => $user_id,
          ];
          TmProsesInfo::insert($proses_bisnis);

        }
      }
      DB::commit();

      $type 				= 'success';
			$save			= '';
			$message			= 'Data Domain Data Berhasil Disimpan.';

    } catch (\Throwable $th) {

      $type 				= 'error';
			$save 			= $th->getMessage();
			$message			= 'Data Domain Aplikasi Gagal Disimpan.';
      DB::rollBack();
    }

    $hasil = ['type'=>$type,
				  'message' => $message,
				  'save' => $save
				 ];
		return json_encode($hasil);
  }

  /**
   * Save a data
   *
   * @param array $input
   */
  public function save_detail(Request $request)
  {
    $user_id = auth()->user()->v_userid;

    try {
      $max_id_detail = $this->tm_informasi_detail->max('id');
      $new_id = intval($max_id_detail) + 1;

      $data_detail = [
        'info_id' => $request->info_id,
        'nama_data' => $request->data_name,
        'uraian_data' => $request->desc_data,
        'komponen_data' => $request->comp_data,
        'tujuan_data' => $request->dest_data,
        'sifat_data' => $request->prop_data,
        'jenis_data1' => $request->type_data1,
        'jenis_data2' => $request->type_data2,
        'jenis_lain' => $request->type_data2_other,
        'format_struct' => $request->format_struct,
        'format_unstruct' => $request->format_unstruct,
        'format_lain' => $request->format,
        'dampak_risiko' => $request->resiko,
        'level_data' => $request->level_data,
        'metode' => $request->pengambilan_data,
        'jumlah_record' => $request->jml_record,
        'validitas' => $request->validitas_data,
        'data_owner' => $request->penanggung_jawab,
        'id' => $new_id,
        'created_by' => $user_id,
        'created_at' => Carbon::now(),
      ];

      $tm_informasi_detail = TmInformasiDetail::insert($data_detail);
      createLog(config('tables.master.tm_informasi_detail'), 'INS', collect($data_detail)->sortKeys());
      
      $last_saved = $this->tm_informasi_detail->find($new_id);
      $last_saved->interoperabilitas()->sync($request->interoperabilitas);

      return true;
    } catch (\Throwable $th) {
      dd($th->getMessage());
      return false;
    }
  }

  /**
   * Get's a data proses bisnis
   *
   * @param int
   * @param \Illuminate\Http\Request $request
   * @return collection
   */
  public function get_detail_data_informasi($id, Request $request)
  {
    $query = $this->tm_informasi_detail
      ->select('id', 'uraian_data', 'komponen_data', 'tujuan_data', 'sifat_data', 'jenis_data1', 'jenis_data2', 'jenis_lain', 'format_struct', 'format_unstruct', 'format_lain', 'dampak_risiko', 'level_data', 'metode', 'jumlah_record', 'validitas', 'data_owner')
      ->with('interoperabilitas', 'interoperabilitas.opd')
      ->where('id',$id)
      ->first();
    // dd(getQueries($query));

    return $query;
  }

  /**
   * Get's a data urusan
   *
   * @param int
   * @param \Illuminate\Http\Request $request
   * @return collection
   */
  public function get_probis_data_detail($id, Request $request)
  {
    $query = $this->TmProsesInfo
      ->select('TM_PROSES.proses_id as proses_id', 'tm_proses.rab_level4 as probis', 'kepmen.nomenklatur_urusan as nomenklatur')
      ->leftJoin('TM_PROSES', 'TM_PROSES.PROSES_ID', '=', 'tm_proses_info.PROSES_ID')
      ->leftJoin('tr_kode_kepmen kepmen', 'kepmen.kode_nomenklatur', '=', 'tm_proses.rab_level4')
      ->where('tm_proses_info.info_id', $id)
      ->orderBy('TM_PROSES.proses_id', 'asc');
    return TmProbisDetailResources::collection($query->paginate($request->limit));
  }

  /**
   * Updates a detail data.
   *
   * @param array
   */
  public function update_detail(Request $request, $id)
  {
    $user_id = auth()->user()->v_userid;
    $tm_informasi_detail = $this->tm_informasi_detail
      ->where('id', $id)
      ->first();
    try {
      if ($tm_informasi_detail) {
        $data = [
          'uraian_data' => $request->desc_data,
          'komponen_data' => $request->comp_data,
          'tujuan_data' => $request->dest_data,
          'sifat_data' => $request->prop_data,
          'jenis_data1' => $request->type_data1,
          'jenis_data2' => $request->type_data2,
          'jenis_lain' => $request->type_data2_other,
          'format_struct' => $request->format_struct,
          'format_unstruct' => $request->format_unstruct,
          'format_lain' => $request->format,
          'dampak_risiko' => $request->resiko,
          'level_data' => $request->level_data,
          'metode' => $request->pengambilan_data,
          'jumlah_record' => $request->jml_record,
          'validitas' => $request->validitas_data,
          'data_owner' => $request->penanggung_jawab,
          'updated_at' => Carbon::now(),
          'updated_by' => $user_id,
        ];
        
        $tm_informasi_detail->update($data);
        createLog(config('tables.master.tm_informasi_detail'), 'UPD', collect($data)->sortKeys());

        $tm_informasi_detail->interoperabilitas()->sync($request->interoperabilitas);

      }

      return true;
    } catch (\Throwable $th) {
      return false;
    }
  }

  /**
   * Deletes a detail data.
   *
   * @param string
   */
  public function delete_detail($request)
  {
    // dd($request->data['id']);
    try {
      $user_id   = auth()->user()->v_userid;
      $data = [
        'deleted_by' => $user_id,
        'deleted_at' => date('Y-m-d H:i:s')
      ];

      $this->tm_informasi_detail
        ->where('id', $request->data['id'])
        ->update($data);

      createLog(config('tables.master.tm_informasi_detail'), 'DEL', collect($data)->sortKeys());
      return true;
    } catch (\Throwable $th) {
      return false;
    }
  }

  /**
   * Deletes a detail data.
   *
   * @param string
   */
  public function delete($request)
  {
    // dd($request->data['info_id']);
    try {
      $user_id   = auth()->user()->v_userid;
      $data = [
        'deleted_by' => $user_id,
        'deleted_at' => date('Y-m-d H:i:s')
      ];

      $this->tm_informasi
        ->where('info_id', $request->data['info_id'])
        ->update($data);

      createLog(config('tables.master.tm_informasi'), 'DEL', collect($data)->sortKeys());
      return true;
    } catch (\Throwable $th) {
      return false;
    }
  }

  public function getDataUnique(Request $request)
	{		
		$query = $this->tm_informasi
            ->select('tm_informasi.info_id', 'tm_informasi.nama_data', 'tm_informasi.opd_id', 'tr_opd.akronim')
            ->leftJoin('TR_OPD', 'tm_informasi.opd_id', 'tr_opd.opd_id')
            ->orderBy('tm_informasi.info_id', 'desc')
					  ->active();

		if(isset($request->opd_id)){
			$query->where('tm_informasi.opd_id',$request->opd_id);
		}

    if(isset($request->exclude)){
			$query->where('tm_informasi.info_id', '<>', $request->exclude);
		}
		
		return $query->get();
	}
}
