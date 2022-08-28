<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface OpdRepositoryInterface
{
  /**
   * Get's a perangkat daerah 
   *
   * @param int
   */
  public function dataPerangkatDaerah(Request $request);

  /**
   * Get's a perangkat daerah  by Slug
   *
   * @param int
   */
  public function dataPerangkatDaerahBySlug(Request $request);
}
