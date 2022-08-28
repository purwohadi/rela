<?php

namespace App\Repositories\Contracts;

interface ReferensiUmumRepositoryInterface
{
  /**
   * get referensi by type
   *
   * @param string $type
   * @return mixed
   */
  public function getByType(string $type);
}
