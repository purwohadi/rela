<?php

namespace App\Http\Resources\Input\RencanaKinerja;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class CapaianJabatanResources extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    $data = [
      'slug_path' => $this->slug_path,
      'v_kode_jabatan' => $this->v_kode_jabatan,
      'v_nama_jabatan' => $this->v_nama_jabatan,
      'si_fixed' => $this->si_fixed,
      'si_variabel' => $this->si_variabel,
    ];

    $data['variabel'] = !$this->ekpVariabel->isEmpty() ? $this->ekpVariabel->map(function ($item) {
      return new CapaianEkpVariabelResources($item);
    }) : [];

    return $data;
  }
}
