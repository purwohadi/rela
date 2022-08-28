<?php

namespace App\Repositories;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Models\FeatureAccessGroup;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\GroupAndFeatureResources;
use App\Models\User;
use App\Repositories\Contracts\GroupRepositoryInterface;
use GMP;

class GroupRepository implements GroupRepositoryInterface
{
  protected $group;
  protected $fag; //featureAccessGroup
  protected $columns = [
    'nama' => 'v_group_name',
    'status' => 'e_status_aktif',
    'featureaccess' => 'v_name',
    'opd' => 'v_opd_id'
  ];

  public function __construct(Group $group, FeatureAccessGroup $fag)
  {
    $this->group = $group;
    $this->fag = $fag;
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
   * Get's groups by specific condition.
   *
   * @return mixed
   */
  public function search(Request $request)
  {
    // handling searchBy
    $query = Group::query();
    $query->with('opd');
    
    if ($request->has('search') && strlen(trim($request->search)) > 0) {
      $mapped = $this->columns;
      $query->where(function ($sql) use ($request, $mapped) {
        $idx = 0;
        foreach ($request->column_filters as $column) {
          $clause = $idx == 0 ? 'where' : 'orWhere';
          if($column != 'featureaccess') {
            $sql->{$clause}(\DB::raw("upper({$mapped[$column]})"), 'like', '%' . strtoupper($request->search) . '%');
          }
          else {
            $sql->orWhereHas('features', function ($q) use ($request) {
              $q->where(\DB::raw("upper(v_name)"), 'like', '%' . strtoupper($request->search) . '%');
            });
          }
          ++$idx;
        }
      });
    }

    if ($request->has('filter_select')) {
      $query->where(function($sql) use ($request) {
        $clause = 'where';
        $sql->{$clause}('e_status_aktif', $request->filter_select);
      });
    }

    // handling sortBy
    if ($request->has('sort_by') && $request->has('sort_desc')) {
      if (!$request->sort_by == 'featureaccess') {
        $query->orderBy($this->columns[$request->sort_by], $request->sort_desc);
      }
    }

    // dd(getQueries($query));

    $results = $request->has('limit')
    ? $query->paginate($request->limit)
    : $query->get();
    return GroupAndFeatureResources::collection($results);
  }

  /**
   * Save a group
   *
   * @param array $input
   */
  public function save(array $input)
  {
    $user_id = auth()->user()->v_userid;
    try {
      $feature = $input['feature_access'];
      $group = $this->group->create([
        'v_group_name' => $input['name'],
        'e_status_aktif' => $input['status'],
        'v_created_by' => $user_id,
        'v_opd_id' => $input['opd_id']
      ]);

      if($group) {
        if(!$feature->isEmpty()) {
          foreach ($feature as $value) {
            $fag = $this->fag->create([
              'i_group_id' => $group->i_id,
              'i_feature_id' => $value,
              'v_created_by' => $user_id
            ]);

            createLog(config('tables.master.feature_access_group'), 'INS', collect($fag)->sortKeys());
          }
        }
      }

      createLog(config('tables.master.group'), 'INS', collect($group)->sortKeys());
      return true;
    } catch (\Throwable $th) {
      Log::error($th);
      return false;
    }
  }

  /**
   * Updates a group.
   *
   * @param int
   * @param array
   */
  public function update($group_id, array $data)
  {
    try {
      $user_id = auth()->user()->v_userid;
      $group = $this->group->findBySlug($group_id);
      $currentData = $this->fag->where('i_group_id', $group->i_id)->pluck('i_feature_id');
      $feature = $data['feature_access'];

      // save old data
      $before = $group;
      $before = collect($before)->merge(collect([
        'feature_access' => $currentData
      ]));

      $group->update([
        'v_group_name' => $data['name'],
        'e_status_aktif' => $data['status'],
        'v_updated_by' => $user_id,
        'v_opd_id' => $data['opd_id']
      ]);

      // feature access yang sebelumnya sudah ada dan tidak berubah
      // $exist = $currentData->intersect($feature)->values();

      // jika di checked maka tambahkan item ke feature access group
      $new = $feature->diff($currentData)->values();

      foreach ($new as $item) {
        $fagN = $this->fag->create([
          'i_group_id' => $group->i_id,
          'i_feature_id' => $item,
          'v_created_by' => $user_id
        ]);

        createLog(config('tables.master.feature_access_group'), 'INS', collect($fagN)->sortKeys());
      }

      // jika di uncheck maka delete item dari feature access group
      $removed = $currentData->diff($feature)->values();
      foreach ($removed as $item) {
        $fagOld = $this->fag->where([
          'i_group_id' => $group->i_id,
          'i_feature_id' => $item
        ])->first();

        $this->fag->where([
          'i_group_id' => $group->i_id,
          'i_feature_id' => $item
        ])->delete();

        createLog(config('tables.master.feature_access_group'), 'DEL', collect($fagOld)->sortKeys());
      }

      $group['feature_access'] = $feature;
      createLog(config('tables.master.group'), 'UPD', [
        'before' => $before->sortKeys(),
        'after' => collect($group)->sortKeys()
      ]);

      return true;
    } catch (\Throwable $th) {
      Log::error($th);
      dd($th);
      return false;
    }
  }
}
