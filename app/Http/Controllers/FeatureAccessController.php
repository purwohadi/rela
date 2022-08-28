<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeatureAccess;
use App\Http\Resources\FeatureAccessListResources;
use App\Repositories\Contracts\FeatureAccessRepositoryInterface;

class FeatureAccessController extends Controller
{
  protected $featureAccess;
  /**
   * FeatureAccessController constructor.
   *
   * @param FeatureAccessRepositoryInterface $featureAccess
   */
  public function __construct(FeatureAccessRepositoryInterface $featureAccess)
  {
    $this->featureAccess = $featureAccess;
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function all(Request $request)
  {
    return $this->featureAccess->all($request);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function search(Request $request)
  {
    $features = $this->featureAccess->search($request);
    return FeatureAccessListResources::collection($features);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      //
  }

  /**
   * Display the specified resource.
   *
   * @param  int id
   * @return \Illuminate\Http\Response
   */
  public function show($slug, FeatureAccess $FeatureAccess)
  {
    $show = $FeatureAccess->findBySlug($slug);
    return new FeatureAccessListResources($show);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function get_parent(Request $request)
  {
    if ($request->has('sort')) {
        $request->merge(['sort' => $request->sort]);
    }

    $parent = $this->featureAccess->get_parent($request->type);

    return $parent;
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      $input = $request->only(['name','alias','type','parent','deskripsi','route','params','icon','order']);
      $featureAccess = $this->featureAccess->save($input);

      $type = $featureAccess ? 'success' : 'error';
      return $this->redirectResponse($request, trans("featureaccess.actions.store.{$type}"), $type, $featureAccess);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
      $input = $request->only(['name','alias','type','parent','deskripsi','route','params','icon','order']);
      $featureAccess = $this->featureAccess->update($request->slug_path, $input);

      $type = $featureAccess ? 'success' : 'error';
      return $this->redirectResponse($request, trans("featureaccess.actions.update.{$type}"), $type, $featureAccess);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
      //
  }

  /**
   * Display the menu that have been used
   *
   * @return Array|Collection
   */
  public function menuUsed()
  {
    $routes = collect($this->featureAccess->used()->pluck('v_route'))->whereNotNull();
    return array_values($routes->toArray());
  }
}
