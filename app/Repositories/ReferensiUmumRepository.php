<?php
namespace App\Repositories;

use App\Models\ReferensiUmum;
use App\Repositories\Contracts\ReferensiUmumRepositoryInterface;

class ReferensiUmumRepository implements ReferensiUmumRepositoryInterface
{
  protected $referensiUmum;

  public function __construct(ReferensiUmum $referensiUmum)
  {
    $this->referensiUmum = $referensiUmum;
  }

  /**
   * get referensi by type
   *
   * @param string $type
   * @return mixed
   */
  public function getByType(string $type)
  {
    return $this->referensiUmum->whereType($type)->get();
  }
}
