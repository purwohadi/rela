<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Resources\GroupNFeatureResources;
use Diskominfotik\Downloadable\Facades\Downloadable;
use App\Repositories\Contracts\GroupRepositoryInterface;

class GroupController extends Controller
{
  protected $group;

  /**
   * GroupController constructor.
   *
   * @param GroupRepositoryInterface $group
   */
  public function __construct(GroupRepositoryInterface $group)
  {
    $this->group = $group;
  }

  /**
   * Display a listing of the role
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function search(Request $request)
  {
    // if ($request->has('sort_by') && $request->sort_by == 'nama') {
    //   $request->merge(['sort_by' => 'v_group_name']);
    // }

    // if ($request->has('export') && $request->export == 'true') {
    // }
    return $this->group->search($request);
  }

  /**
   * Display a listing of the user
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function get_group_for_users(Request $request)
  {
    if ($request->has('sort_by')) {
        $request->merge(['sort_by' => $request->sort_by]);
    }

    $group = $this->group->all_by_status($request->status);
                
    return $group;
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $find = Group::where('v_group_name', $request->name)->first();
    if($find) {
      return $this->redirectResponse($request, 'Data group sudah ada!', 'error', 'duplicate');
    }

    $request->merge(['feature_access' => collect($request->has('feature_access') ? $request->feature_access : [])]);

    $input = $request->only(['name', 'status', 'opd_id', 'feature_access']);
    $group = $this->group->save($input);

    $type = $group ? 'success' : 'error';
    return $this->redirectResponse($request, trans("group.actions.store.{$type}"), $type, $group);
  }

  /**
   * Show by slug
   *
   * @param  \Illuminate\Http\Request  $request
   * @return String
   */
  public function show($slug, Group $group)
  {
    $show = $group->findBySlug($slug);
    return new GroupNFeatureResources($show);
  }

  /**
   * Edit group
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request)
  {
    $request->merge(['feature_access' => collect($request->has('feature_access') ? array_map('intval', $request->feature_access) : [])]);
    $input = $request->only(['name', 'status', 'opd_id', 'feature_access']);

    $group = $this->group->update($request->slug_path, $input);
    $type = $group ? 'success' : 'error';

    return $this->redirectResponse($request, trans("group.actions.update.{$type}"), $type, $group);
  }

  public function showAll()
  {
    $show = $this->group->all();
    return ($show);
  }
}
