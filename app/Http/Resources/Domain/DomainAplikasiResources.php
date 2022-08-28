<?php

namespace App\Http\Resources\Domain;

use Illuminate\Http\Resources\Json\JsonResource;

class DomainAplikasiResources extends JsonResource
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
        'nama_apl' => $this->nama_apl,
        'raa_level1' => $this->raa_level_1,
        'raa_level2' => $this->raa_level_2,
        'raa_level3' => $this->raa_level_3,
        'raa_level4' => $this->raa_level_4,
        'app_ownership' => $this->app_ownership,
        'slug_path' => $this->slug_path
    ];

    return $data;
  }
}
