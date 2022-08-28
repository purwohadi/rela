<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Diskominfotik\Downloadable\Facades\Downloadable;

class RoleController extends Controller
{
  protected $role;

  /**
   * RoleController constructor.
   *
   * @param RoleRepositoryInterface $role
   */
  public function __construct(RoleRepositoryInterface $role)
  {
    $this->role = $role;
  }

  /**
   * Display a listing of the role
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function search(Request $request)
  {
    if ($request->has('export') && $request->export == 'true') {
      $roles = $this->role->search($request);
      // foreach ($roles as $role) {
      //   dd(array_column($role->permissions->toArray(), 'name'));
      //   // dd($role->permissions->toArray());
      // }
      $customHeader = function ($data) {
        // $permissions = array_column($data['permissions'], 'name');
        $name = $data->name;
        return [
          'Nama Peran' => $name,
          'Nama Penjagaan' => $data->guard_name,
          // 'Daftar Hak Akses' => implode(', ', $permissions)
        ];
      };

      return Downloadable::as($request->type)
      ->withData($roles->toArray())
        ->withFilename('Daftar Peran')
        ->get($customHeader);
    }
    return $this->role->search($request);
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
    $role = $this->role->save($input);

    if ($role->exists && $role->wasRecentlyCreated) {
      $type = 'success';
    } else {
      $type = $role->exists ? 'info' : 'error';
    }

    return $this->redirectResponse($request, trans("role.actions.update.{$type}"), $type, $role);
  }

  /**
   * Check role by name.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return String
   */
  public function exist(Request $request)
  {
    $role = $this->role->findByName($request->name);
    return $role
      ? 'true'
      : 'false';
  }

  /**
   * Check role exclude that role
   *
   * @param Request $request
   * @return String
   */
  public function exclude(Request $request)
  {
    $role = $this->role->get($request->id);
    if ($role) {
      if (strtolower($role->name) == strtolower($request->name)) return 'false';
      return $this->exist($request);
    }
    return 'false';
  }

  /**
   * Edit role
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request)
  {
    $role = $this->role->update($request->id, $request->only(['name', 'guard_name']));
    $type = $role ? 'success' : 'error';
    return $this->redirectResponse($request, trans("role.actions.update.{$type}"), $type, $role);
  }

  /**
   * Delete role
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function drop(Request $request)
  {
    dd($request->all());
    $role = $this->role->delete($request->id);
    $type = $role ? 'success' : 'error';
    return $this->redirectResponse($request, trans("role.actions.delete.{$type}"), $type);
  }

  public function sync(Request $request)
  {
    $role = $this->role->syncPermissions($request->role, $request->permissions);
    $type = $role ? 'success' : 'error';
    return $this->redirectResponse($request, trans("role.actions.sync-permissions.{$type}"), $type);
  }
}
