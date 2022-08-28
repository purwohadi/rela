<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\PetaRencanaRepositoryInterface;
use Illuminate\Http\Request;

class PetaRencanaController extends Controller
{
  protected $petaRencanaRepository;

  public function __construct(PetaRencanaRepositoryInterface $petaRencanaRepository)
  {
    $this->petaRencanaRepository = $petaRencanaRepository;
  }

  public function getBidurByOPD(Request $request)
  {
    return $this->petaRencanaRepository->getBidurByOPD($request);
  }

  public function getRefInisiatif(Request $request)
  {
    return $this->petaRencanaRepository->getRefInisiatif($request);
  }

  public function getDataRPD(Request $request)
  {
    return $this->petaRencanaRepository->getDataRPDbyBidur($request);
  }

  public function getInisiatif(Request $request)
  {
    return $this->petaRencanaRepository->getInisiatif($request);
  }

  public function searchInisiatif(Request $request)
  {
    return $this->petaRencanaRepository->searchInisiatif($request);
  }

  public function save(Request $request)
  {
    $saveData		= json_decode($this->petaRencanaRepository->save($request));
    $type 			= $saveData->type;
    $message 		= $saveData->message;
    $save 			= $saveData->save;
    return $this->redirectResponse($request, trans("{$message}"), $type, $save);
  }

  public function update(Request $request)
  {
    $updatedData	= json_decode($this->petaRencanaRepository->update($request));
    $type 			= $updatedData->type;
    $message 		= $updatedData->message;
    $save 			= $updatedData->save;
    return $this->redirectResponse($request, trans("{$message}"), $type, $save);
  }
  
  public function delete(Request $request)
  {
    $deletedData	= json_decode($this->petaRencanaRepository->delete($request));
    $type 			= $deletedData->type;
    $message 		= $deletedData->message;
    $errorMsg 			= $deletedData->errorMsg;
    return $this->redirectResponse($request, trans("{$message}"), $type, $errorMsg);
  }

  public function getKegiatanTree(Request $request)
  {
    return $this->petaRencanaRepository->getKegiatanTree($request);
  }
}
