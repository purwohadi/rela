<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\PermissionRepositoryInterface;

class PermissionController extends Controller
{
  protected $permission;

  /**
   * PermissionController constructor.
   *
   * @param PermissionRepositoryInterface $permission
   */
  public function __construct(PermissionRepositoryInterface $permission)
  {
    $this->permission = $permission;
  }

  /**
   * Display a listing of the permission
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function search(Request $request)
  {
    return $this->permission->search($request);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $input = $request->only(['name', 'guard_name']);
    $permission = $this->permission->save($input);

    if ($permission->exists && $permission->wasRecentlyCreated) {
      $type = 'success';
    } else {
      $type = $permission->exists ? 'info' : 'error';
    }

    return $this->redirectResponse($request, trans("permission.actions.store.{$type}"), $type, $permission);
  }

  /**
   * Check permission by name.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return String
   */
  public function exist(Request $request)
  {
    $permission = $this->permission->findByName($request->name);
    return $permission
      ? 'true'
      : 'false';
  }

  /**
   * Check permission exclude that permission
   *
   * @param Request $request
   * @return String
   */
  public function exclude(Request $request)
  {
    $permission = $this->permission->get($request->id);
    if ($permission) {
      if (strtolower($permission->name) == strtolower($request->name)) return 'false';
      return $this->exist($request);
    }
    return 'false';
  }

  /**
   * Edit permission
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request)
  {
    $permission = $this->permission->update($request->id, (array)$request->only(['name', 'guard_name']));
    $type = $permission ? 'success' : 'error';
    return $this->redirectResponse($request, trans("permission.actions.update.{$type}"), $type, $permission);
  }

  /**
   * Delete permission
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function drop(Request $request)
  {
    $permission = $this->permission->delete($request->id);
    $type = $permission ? 'success' : 'error';
    return $this->redirectResponse($request, trans("permission.actions.delete.{$type}"), $type);
  }
}
