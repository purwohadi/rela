<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Rabl3MinResources extends JsonResource
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
      // 'slug_path' => $this->slug_path,
      'rabl' => $this->rabl3,

      // 'slug_path' => $this->slug_path,
      // 'kode_rabl' => $this->kode_rabl,
      // 'rabl' => $this->kode_rabl . " " . $this->rabl3,
    ];

    return $data;
  }
}
