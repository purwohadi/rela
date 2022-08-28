<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DomainInfrastrukturSplpResources  extends JsonResource
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
      'opd_id' => $this->opd_id,
      'rai_level_1' => $this->rai_level_1,
      'rai_level_2' => $this->rai_level_2,
      'rai_level_3' => $this->rai_level_3,
      'rai_level_4' => $this->rai_level_4,
      'nama' => $this->nama,
      'instansi' => $this->instansi,
      'deskripsi' => $this->deskripsi,
      'jenis' => $this->jenis,
      'app_dihubungkan' => $this->app_dihubungkan,
      'app_terhubung' => $this->app_terhubung,
      'domain_code' => $this->domain_code,
      'id' => $this->id,
    ];

    return $data;
  }
}
