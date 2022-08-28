<?php

namespace App\Http\Controllers;

use App\Utils\MenuBuilder;
use Illuminate\Http\Request;
use App\Repositories\Contracts\MenuRepositoryInterface;

class MenuController extends Controller
{
  protected $menu;

  /**
   * MenuController constructor.
   *
   * @param MenuRepositoryInterface $menu
   */
  public function __construct(MenuRepositoryInterface $menu)
  {
    $this->menu = $menu;
  }

  /**
   * Display a listing of the menu
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function search(Request $request)
  {
    return $this->menu->search($request);
  }

  /**
   * Display a listing of the parents menu
   *
   * @return Array|Collections
   */
  public function getParents()
  {
    return $this->menu->getParents();
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request) {
    $menu = $this->menu->save($request->toArray());
    if ($menu->exists && $menu->wasRecentlyCreated) {
      $type = 'success';
    } else {
      $type = $menu->exists ? 'info' : 'error';
    }

    return $this->redirectResponse($request, trans("menu.actions.store.{$type}"), $type, $menu);
  }

  /**
   * Check permission by key.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return String
   */
  public function exist(Request $request)
  {
    $key = collect($request->keys())->shift();
    $menu = $this->menu->findByKey($key, $request->$key);
    return $menu
      ? 'true'
      : 'false';
  }

  /**
   * Check menu exclude that menu
   *
   * @param Request $request
   * @return String
   */
  public function exclude(Request $request)
  {
    $menu = $this->menu->get($request->id);
    if ($menu) {
      if (strtolower($menu->route) == strtolower($request->route)) return 'false';
      $other = $this->menu->findByKey('route', $request->route);
      return $other ? 'true' : 'false';
    }
    return 'false';
  }

  /**
   * Display the routes that have been used
   *
   * @return Array|Collection
   */
  public function usedRoutes()
  {
    $routes = collect($this->menu->all()->pluck('route'))->whereNotNull();
    return array_values($routes->toArray());
  }

  /**
   * Edit menu
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request)
  {
    $fields = [ 'group'
              , 'label'
              , 'icon'
              , 'tags'
              , 'route'
              , 'parent'
              , 'permission_id'
              , 'order_no'
              , 'visible'
              ];
    $menu = $this->menu->update($request->id, $request->only($fields));
    $type = $menu ? 'success' : 'error';
    return $this->redirectResponse($request, trans("menu.actions.update.{$type}"), $type, $menu);
  }

  /**
   * Delete menu
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function drop(Request $request)
  {
    $menu = $this->menu->delete($request->id);
    $type = $menu ? 'success' : 'error';
    return $this->redirectResponse($request, trans("menu.actions.delete.{$type}"), $type);
  }

  /**
   * Get Structure Menu
   *
   * @return Array
   */
  public function structure()
  {
    $menu = new MenuBuilder();
    return [
      'structure' => $menu->getMenuViaPermissions(),
      'flatten' => $menu->getMenuViaPermissions(true)
    ];
  }
}
