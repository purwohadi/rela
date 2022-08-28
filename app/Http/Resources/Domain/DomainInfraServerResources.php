<?php

namespace App\Http\Resources\Domain;

use Illuminate\Http\Resources\Json\JsonResource;

class DomainInfraServerResources extends JsonResource
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
      'nama' => $this->nama,
      'opd_id' => $this->opd_id,
      'instansi' => $this->instansi,
      'rai_level1' => $this->rai_level_1,
      'rai_level2' => $this->rai_level_2,
      'rai_level3' => $this->rai_level_3,
      'rai_level4' => $this->rai_level_4,
      'domain_code' => $this->domain_code,
      'id_metadata_terkait' => $this->id_metadata_terkait,
      'id' => $this->id,
    ];

    return $data;
  }
}
