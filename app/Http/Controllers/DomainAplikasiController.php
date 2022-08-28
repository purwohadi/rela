<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Repositories\Contracts\DomainAplikasiRepositoryInterface;

class DomainAplikasiController extends Controller
{
	protected $domainAplikasiRepositoryInterface;

	/**
	 * DomainAplikasiController constructor.
	 *
	 * @param DomainAplikasiRepositoryInterface $permission
	 */
	public function __construct (DomainAplikasiRepositoryInterface $domainAplikasiRepositoryInterface) {
		$this->domainAplikasiRepositoryInterface			= $domainAplikasiRepositoryInterface;
	}

	/** Get data domain aplikasi*/
	public function getDataBy(Request $request)
	{
		return $this->domainAplikasiRepositoryInterface->getDataBy($request);
	}

	public function getDataAplikasi(Request $request)
	{
		return $this->domainAplikasiRepositoryInterface->getDataAplikasi($request);
	}

	public function listData(Request $request)
	{
		return $this->domainAplikasiRepositoryInterface->listData($request);
	}

	public function save(Request $request)
	{
	  $saveData		= json_decode($this->domainAplikasiRepositoryInterface->save($request));
	  $type 			= $saveData->type;
	  $message 		= $saveData->message;
	  $save 			= $saveData->save;
	  return $this->redirectResponse($request, trans("{$message}"), $type, $save);
	}
  
	public function update(Request $request)
	{
	  $updatedData	= json_decode($this->domainAplikasiRepositoryInterface->update($request));
	  $type 			= $updatedData->type;
	  $message 		= $updatedData->message;
	  $save 			= $updatedData->save;
	  return $this->redirectResponse($request, trans("{$message}"), $type, $save);
	}
  
	public function delete(Request $request)
	{
	  $deletedData	= json_decode($this->domainAplikasiRepositoryInterface->delete($request));
	  $type 			= $deletedData->type;
	  $message 		= $deletedData->message;
	  $errorMsg 			= $deletedData->errorMsg;
	  
	  return $this->redirectResponse($request, trans("{$message}"), $type, $errorMsg);
	}

	public function show(Request $request, $id)
	{
		return $this->domainAplikasiRepositoryInterface->show($id);
	}

	public function getAplikasiDetail(Request $request)
	{
		return $this->domainAplikasiRepositoryInterface->getAplikasiDetail($request);
	}
}
