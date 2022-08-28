<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface DomainProsesRepositoryInterface
{
  /**
   * Get's a perangkat daerah 
   *
   * @param int
   */
  public function dataProsesBisnis(Request $request);
}
