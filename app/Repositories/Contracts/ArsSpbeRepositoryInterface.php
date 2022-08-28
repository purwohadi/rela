<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface ArsSpbeRepositoryInterface
{
  
  public function searchRal(Request $request);
  public function searchRef(Request $request);

}
