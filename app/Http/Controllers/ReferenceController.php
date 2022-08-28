<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\ReferenceRepositoryInterface;

class ReferenceController extends Controller
{
  protected $reference;

  /**
   * ReferenceController constructor.
   *
   * @param ReferenceRepositoryInterface $reference
   */
  public function __construct(ReferenceRepositoryInterface $reference)
  {
    $this->reference = $reference;
  }

  /**
   * Display a listing of the reference
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function search(Request $request)
  {
    return $this->reference->search($request);
  }

  /**
   * Display a listing of the reference by type
   *
   * @param String $type
   * @return \Illuminate\Http\Response
   */
  public function getByType(String $type)
  {
    return $this->reference->getByType($type);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $input = $request->only(['key', 'value', 'type']);
    $reference = $this->reference->save($input);

    if ($reference->exists && $reference->wasRecentlyCreated) {
      $type = 'success';
    } else {
      $type = $reference->exists ? 'info' : 'error';
    }

    return $this->redirectResponse($request, trans("reference.actions.store.{$type}"), $type, $reference);
  }

  /**
   * Check reference by name.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return String
   */
  public function exist(Request $request)
  {
    $reference = $this->reference->getByKeyType($request->key, $request->type);
    return $reference
      ? 'true'
      : 'false';
  }

  /**
   * Check reference exclude that reference
   *
   * @param Request $request
   * @return String
   */
  public function exclude(Request $request)
  {
    $reference = $this->reference->get($request->id);
    if ($reference) {
      if (
        strtolower($reference->key) == strtolower($request->key) &&
        strtolower($reference->type) == strtolower($request->type)
      ) return 'false';
      return $this->exist($request);
    }
    return 'false';
  }

  /**
   * Edit reference
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request)
  {
    $reference = $this->reference->update($request->id, (array) $request->only(['key', 'value', 'type']));
    $type = $reference ? 'success' : 'error';
    return $this->redirectResponse($request, trans("reference.actions.update.{$type}"), $type, $reference);
  }

  /**
   * Delete reference
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function drop(Request $request)
  {
    $reference = $this->reference->delete($request->id);
    $type = $reference ? 'success' : 'error';
    return $this->redirectResponse($request, trans("reference.actions.delete.{$type}"), $type);
  }
}
