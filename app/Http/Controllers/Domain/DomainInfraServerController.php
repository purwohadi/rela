<?php

namespace App\Http\Controllers\Domain;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\DomainInfraServerRepositoryInterface;
use Illuminate\Http\Request;

class DomainInfraServerController extends Controller
{
  protected $domainInfraServer;

  public function __construct(DomainInfraServerRepositoryInterface $domainInfraServer)
  {
    $this->domainInfraServer = $domainInfraServer;
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function listData(Request $request)
  {
    return $this->domainInfraServer->listData($request);
  }

  public function show($id)
  {
    return $this->domainInfraServer->show($id);
  }

  public function save(Request $request)
  {
    $saveData		= json_decode($this->domainInfraServer->save($request));
    $type 			= $saveData->type;
    $message 		= $saveData->message;
    $save 			= $saveData->save;
    return $this->redirectResponse($request, trans("{$message}"), $type, $save);
  }

  public function update(Request $request)
  {
    $updatedData	= json_decode($this->domainInfraServer->update($request));
    $type 			= $updatedData->type;
    $message 		= $updatedData->message;
    $save 			= $updatedData->save;
    return $this->redirectResponse($request, trans("{$message}"), $type, $save);
  }

  public function delete(Request $request)
  {
    $deletedData	= json_decode($this->domainInfraServer->delete($request));
    $type 			= $deletedData->type;
    $message 		= $deletedData->message;
    $errorMsg 			= $deletedData->errorMsg;
    return $this->redirectResponse($request, trans("{$message}"), $type, $errorMsg);
  }
}
