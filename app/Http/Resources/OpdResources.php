<?php

namespace App\Http\Resources;

use App\Http\Resources\GroupResources;
use Illuminate\Http\Resources\Json\JsonResource;

class OpdResources extends JsonResource
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
      'akronim' => $this->akronim,
      'nama_opd' => $this->nama_opd,
      'opd_group' => $this->opd_group,
    ];

    return $data;
  }
}
