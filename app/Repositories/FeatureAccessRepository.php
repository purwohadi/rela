<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\FeatureAccess;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\FeatureAccessResources;
use App\Repositories\Contracts\FeatureAccessRepositoryInterface;

class FeatureAccessRepository implements FeatureAccessRepositoryInterface
{
  protected $featureAccess;

  protected $columns = [
    'name' => 'v_name',
    'alias' => 'v_alias',
    'type' => 'e_type',
    'parent' => 'parent.v_name',
    'description' => 'v_description'
  ];

  protected $sorting = [ 'parent' => 'i_parentid' ];

  public function __construct(FeatureAccess $featureAccess)
  {
    $this->featureAccess = $featureAccess;
  }

  /**
   * Get's all featureAccess.
   *
   * @return mixed
   */
  public function all()
  {
    $results = $this->featureAccess
      ::orderBy('i_order_no')
      ->orderBy('e_type')
      ->orderBy('v_name')
      ->get();

    return FeatureAccessResources::collection($results);
  }

  /**
   * Get's a featureAccess by it's ID
   *
   * @param int
   */
  public function get($featureAccess_id)
  {
    return $this->featureAccess->find($featureAccess_id);
  }

  /**
   * Get's a featureAccess induk
   *
   * @param int
   */
  public function get_parent($type)
  {
    return $this->featureAccess->whereIn('e_type', $type)->get();
  }

  /**
   * Get's a featureAccess by it's name
   *
   * @param String $name
   * @param String $guard_name
   */
  public function findByName($name, $guard_name = null)
  {
    try {
      $featureAccess = $this->featureAccess->findByName($name, $guard_name);
      return $featureAccess;
    } catch (\Exception $e) {
      return false;
    }
  }

  /**
   * Get's featureAccesss by specific condition.
   *
   * @return mixed
   */
  public function search(Request $request)
  {
    $features = $this->featureAccess->query();

    // handling searchBy
    if ($request->has('search') && strlen(trim($request->search)) > 0) {
      $features->searchingBy(
        $this->columns,
        $request->column_filters,
        $request->search
      );
    }

    // handling sortBy
    if ($request->has('sort_by')) {
      $column = array_key_exists($request->sort_by, $this->sorting)
        ? $this->sorting[$request->sort_by]
        : $this->columns[$request->sort_by];

      $features->orderBy($column, $request->sort_desc ?? 'asc');
    }

    return $features->paginate($request->limit);
  }

  /**
   * Save a featureAccess
   *
   * @param array $input
   */
  public function save(array $input)
  {
    // 'name','alias','type','parent','deskripsi','route','params','icon','order'
    $user_id = auth()->user()->v_userid;
    try {
      $featureAccess = $this->featureAccess->create([
        'v_name' => $input['name'],
        'v_alias' => $input['alias'],
        'e_type' => $input['type'],
        'i_parentid' => $input['parent'],
        'v_description' => $input['deskripsi'],
        'v_route' => $input['route'],
        'v_params' => $input['params'],
        'v_icon' => $input['icon'],
        'i_order_no' => $input['order'],
        'v_created_by' => $user_id
      ]);

      createLog(config('tables.master.feature_access'), 'INS', collect($featureAccess)->sortKeys());
      return true;
    } catch (\Throwable $th) {
      Log::error($th);
      return false;
    }
  }

  /**
   * Updates a featureAccess.
   *
   * @param int
   * @param array
   */
  public function update($id, array $input)
  {
    $user_id = auth()->user()->v_userid;
    try {
      $featureAccess = $this->featureAccess->findBySlug($id);

      $featureAccess->update([
        'v_name' => $input['name'],
        'v_alias' => $input['alias'],
        'e_type' => $input['type'],
        'i_parentid' => $input['parent'],
        'v_description' => $input['deskripsi'],
        'v_route' => $input['route'],
        'v_params' => $input['params'],
        'v_icon' => $input['icon'],
        'i_order_no' => $input['order'],
        'v_updated_by' => $user_id
      ]);

      createLog(config('tables.master.feature_access'), 'UPD', collect($featureAccess)->sortKeys());

      return true;
    } catch (\Throwable $th) {
      Log::error($th);
      return false;
    }
  }

  /**
   * Deletes a featureAccess.
   *
   * @param int
   */
  public function delete($featureAccess_id)
  {
    $featureAccess = $this->get($featureAccess_id);
    $user = $featureAccess->users()->count();
    if ($user) return false;
    return $featureAccess->delete();
  }

  public function syncPermissions($featureAccess_name, Array $permissions)
  {
    try {
      $featureAccess = $this->findByName($featureAccess_name);
      return $featureAccess->syncPermissions($permissions);
    } catch (\Exception $ex) {
      return false;
    }
  }

  public function used()
  {
    $results = $this->featureAccess::where('e_type', 'menu')->get();
    return $results;
  }
}
