<?php

namespace App\Http\Resources\Domain;

use Illuminate\Http\Resources\Json\JsonResource;

class DomainAplikasiDetailResources extends JsonResource
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
        'opd_id' => $this->opd_input_id,
        'nama_opd' => $this->nama_opd,
        'app_ownership' => $this->app_ownership,
        'issues' => $this->issues,
        'slug_path' => $this->slug_path
    ];

    return $data;
  }
}
