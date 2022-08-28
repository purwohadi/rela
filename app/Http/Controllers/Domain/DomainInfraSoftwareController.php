<?php

namespace App\Http\Controllers\Domain;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\DomainInfraSoftwareRepositoryInterface;
use Illuminate\Http\Request;

class DomainInfraSoftwareController extends Controller
{
  protected $domainInfraSoftware;

  public function __construct(DomainInfraSoftwareRepositoryInterface $domainInfraSoftware)
  {
    $this->domainInfraSoftware = $domainInfraSoftware;
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function listData(Request $request)
  {
    //return 'tes';
    return $this->domainInfraSoftware->listData($request);
  }

  public function show($id)
  {
    return $this->domainInfraSoftware->show($id);
  }

  public function save(Request $request)
  {
    $saveData		= json_decode($this->domainInfraSoftware->save($request));
    $type 			= $saveData->type;
    $message 		= $saveData->message;
    $save 			= $saveData->save;
    return $this->redirectResponse($request, trans("{$message}"), $type, $save);
  }

  public function update(Request $request, $id)
  {
    $updatedData	= json_decode($this->domainInfraSoftware->update($request, $id));
    $type 			= $updatedData->type;
    $message 		= $updatedData->message;
    $save 			= $updatedData->save;
    return $this->redirectResponse($request, trans("{$message}"), $type, $save);
  }

  public function delete(Request $request, $id)
  {
    $deletedData	= json_decode($this->domainInfraSoftware->delete($request, $id));
    $type 			= $deletedData->type;
    $message 		= $deletedData->message;
    $errorMsg 			= $deletedData->errorMsg;
    return $this->redirectResponse($request, trans("{$message}"), $type, $errorMsg);
  }

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getDataBy(Request $request)
	{
		return $this->domainInfraSoftware->getDataBy($request);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getMetadataKeamanan(Request $request)
	{
		return $this->domainInfraSoftware->getDataMetadataKeamanan($request);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getMetadataSplp(Request $request)
	{
		return $this->domainInfraSoftware->getDataMetadataSplp($request);
	}

  public function getUsedSoftware(Request $request)
	{
    //return 'tes';
    return $this->domainInfraSoftware->getUsedSoftware($request);
	}

}
