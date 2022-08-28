<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface ProgramRoadmapRepositoryInterface
{
  public function save(Request $request);
  // public function update(Request $request);
  public function getProgramRoadmapByBidur(Request $request);
}
