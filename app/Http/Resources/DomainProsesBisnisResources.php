<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DomainProsesBisnisResources extends JsonResource
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
      'proses_id' => $this->proses_id,
      'opd_id' => $this->opd_id,
      'nama_opd' => $this->nama_opd,
      'rab_level1' => $this->rab_level1,
      'rab_level2' => $this->rab_level2,
      'rab_level3' => $this->rab_level3 ? $this->rab_level3 : "-",
      'rab_level4' => $this->kode_rab_level4 . ' ' .$this->rab_level4,
      'domain_code' => $this->domain_code,
      'id' => $this->id,
    ];

    return $data;
  }
}
