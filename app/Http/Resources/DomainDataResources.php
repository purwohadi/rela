<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DomainDataResources extends JsonResource
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
      'info_id' => $this->info_id,
      'rad_level1' => $this->rad_level_1,
      'rad_level2' => $this->rad_level_2,
      'rad_level3' => $this->rad_level_3,
      'rad_level1_nama' => $this->rad_level_1_nama,
      'rad_level2_nama' => $this->rad_level_2_nama,
      'rad_level3_nama' => $this->rad_level_3_nama,
      'nama_opd' => $this->nama_opd,
      'nama_data' => $this->nama_data
    ];

    return $data;
  }
}
