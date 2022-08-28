<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgramMinResources extends JsonResource
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
      'kode_rabl' => $this->kode_rabl,
      'program' => $this->kode_rabl . " " . $this->program,
    ];

    return $data;
  }
}
