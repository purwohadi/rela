<?php

namespace App\Repositories;

use App\Http\Controllers\RefrensiKemendagriController;
use App\Models\{User, UserGroup, TrTupoksi};
use Illuminate\Http\Request;
use App\Http\Resources\RefrensiTupoksiResources;
use App\Repositories\Contracts\RefrensiTupoksiRepositoryInterface;
use GMP;

class RefrensiTupoksiRepository implements RefrensiTupoksiRepositoryInterface
{
  protected $refkemendagri;
  protected $user;
  protected $user_group;

  protected $columns = [
    'id_entitas' => 'id_entitas',
    'ass_sekda' => 'ass_sekda',
    'tipe_entitas' => 'tipe_entitas',
    'nama_unit' => 'tipe_entitas',
    'nama_opd' => 'nama_opd',
    'upt' => 'upt',
    'tupoksi' => 'tupoksi',
    'tupoksi_desc' => 'tupoksi_desc',
    'tu_ref' => 'tu_ref',
  ];


  /**
   * User constructor
   *
   * @param User $user
   * @param UserGroup $user_group
   * @param TrTupoksi $tr_tupoksi
   */
  public function __construct(
    User $user,
    UserGroup $user_group,
    TrTupoksi $ref_tupoksi
  ) {
    $this->user = $user;
    $this->user_group = $user_group;
    $this->ref_tupoksi = $ref_tupoksi;
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
    $query = $this->ref_tupoksi->orderBy($this->columns['id_entitas'], 'asc');

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
      $query->where('opd_id', $request->opd_id);
    }

    return RefrensiTupoksiResources::collection($query->paginate($request->limit));
  }

  /**
   * Save a group
   *
   * @param array $input
   */
  public function save(array $input)
  {
  }

  /**
   * Updates a group.
   *
   * @param int
   * @param array
   */
  public function update($group_id, array $data)
  {
  }

  public function get_option(Request $request)
  {
    $query = $this->ref_tupoksi
      ->where("opd_id", $request->opd_id)
      // ->whereNotNull("nama_unit")
      ->orderBy("tupoksi");

    return $query->get();
  }
}
