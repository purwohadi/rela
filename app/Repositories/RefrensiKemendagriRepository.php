<?php

namespace App\Repositories;

use App\Http\Controllers\RefrensiKemendagriController;
use App\Models\{User, UserGroup, TrKodeKepmen};
use Illuminate\Http\Request;
use App\Http\Resources\RefrensiKemendagriResources;
use App\Repositories\Contracts\RefrensiKemendagriRepositoryInterface;
use GMP;

class RefrensiKemendagriRepository implements RefrensiKemendagriRepositoryInterface
{
  protected $refkemendagri;
  protected $user;
  protected $user_group;

  protected $columns = [
    'urusan' => 'urusan',
    'bid_urusan' => 'bid_urusan',
    'program' => 'program',
    'kegiatan' => 'kegiatan',
    'sub_kegiatan' => 'sub_kegiatan',
    'nomenklatur_urusan' => 'nomenklatur_urusan',
    'kinerja' => 'kinerja',
    'indikator' => 'indikator',
    'satuan' => 'satuan',
  ];


  /**
   * User constructor
   *
   * @param User $user
   * @param UserGroup $user_group
   * @param RefrensiKemendagri $user_group
   */
  public function __construct(
    User $user,
    UserGroup $user_group,
    TrKodeKepmen $ref_kemendagri
  ) {
    $this->user = $user;
    $this->user_group = $user_group;
    $this->ref_kemendagri = $ref_kemendagri;
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
    $query = $this->ref_kemendagri->orderBy('kode_nomenklatur', 'asc');

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

    if ($request->has('is_provinsi')) {
      $query->where('is_provinsi', $request->is_provinsi);
    }
    // if ($request->has('filter_select')) {
    //   $query->where(function ($sql) use ($request) {
    //     $clause = 'where';
    //     $sql->{$clause}(DB::raw("upper(e_user_enable)"), $request->filter_select);
    //   });
    // }

    // if (!auth()->user()->is_admin) {
    //   $query->whereHas('pegawai', function ($q) {
    //     if (auth()->user()->is_admin_skpd) {
    //       $q->where('v_spmu', session()->get('current_spmu'));
    //     }

    //     if (auth()->user()->is_admin_ukpd || auth()->user()->is_common_user) {
    //       $q->where('v_kolok', session()->get('current_kolok'));
    //     }
    //   });
    // }
    // dd(getQueries($query));
    return RefrensiKemendagriResources::collection($query->paginate($request->limit));
  }

  public function getRefProgram(Request $request) {
    $query = $this->ref_kemendagri->whereNull('kegiatan')
      ->whereNull('sub_kegiatan')
      ->whereNotNull('program');
    if ($request->bidur_kode) {
      $bidur_kode = explode(".", $request->bidur_kode);
      $urusan = $bidur_kode[0];
      $bid_urusan = $bidur_kode[1];
      $query->where('urusan', (int) $urusan);
      $query->where('bid_urusan', $bid_urusan);
    }
    return $query->get();
  }

  public function getRefKegiatan(Request $request) {
    $query = $this->ref_kemendagri->whereNull('sub_kegiatan')
      ->whereNotNull('kegiatan');
    if ($request->program) {
      $query->where('kode_nomenklatur', 'like','%'.$request->program.'%');
    }
    return $query->get();
  }

  public function getRefSubKegiatan(Request $request) {
    $query = $this->ref_kemendagri->whereNotNull('sub_kegiatan');
    if ($request->kegiatan) {
      $query->where('kode_nomenklatur', 'like','%'.$request->kegiatan.'%');
    }
    return $query->get();
  }
}
