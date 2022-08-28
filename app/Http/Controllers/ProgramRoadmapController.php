<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\ProgramRoadmapRepositoryInterface;
use Illuminate\Http\Request;

class ProgramRoadmapController extends Controller
{
  protected $program_roadmap;

  public function __construct(ProgramRoadmapRepositoryInterface $program_roadmap)
  {
    $this->program_roadmap = $program_roadmap;
  }

  public function save(Request $request)
  {
    $saveData		= json_decode($this->program_roadmap->save($request));
    $type 			= $saveData->type;
    $message 		= $saveData->message;
    $save 			= $saveData->save;
    return $this->redirectResponse($request, trans("{$message}"), $type, $save);
  }

  public function update(Request $request)
  {
    $updatedData	= json_decode($this->program_roadmap->update($request));
    $type 			= $updatedData->type;
    $message 		= $updatedData->message;
    $save 			= $updatedData->save;
    return $this->redirectResponse($request, trans("{$message}"), $type, $save);
  }

  public function getProgramRoadmap(Request $request)
  {
    return $this->program_roadmap->getProgramRoadmapByBidur($request);
  }
}
