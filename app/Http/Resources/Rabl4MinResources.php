<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Rabl4MinResources extends JsonResource
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
      'rabl' => $this->kode_rabl . " " . $this->rabl4,
      'is_provinsi' => $this->is_provinsi
    ];

    return $data;
  }
}
