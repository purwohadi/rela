<?php

namespace App\Repositories\Contracts;
use Illuminate\Http\Request;

interface DashboardRepositoryInterface
{

  /**
   * Get's dpt 2019 by specific condition.
   *
   * @return mixed
   */
  public function getDpt(Request $request);
}
