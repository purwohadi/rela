<?php

namespace App\Http\Resources\Roadmap;

use Illuminate\Http\Resources\Json\JsonResource;

class BidurResources extends JsonResource
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
      'bidur_kode' => $this->bidur_kode,
      'bidur_nama' => $this->bidur_nama,
      'opd_id' => $this->opd_id,
    ];

    return $data;
  }
}
