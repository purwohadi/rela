<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AbsensiResources extends JsonResource
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
      'id' => $this->id,
      'sakit' => $this->sakit,
      'ijin' => $this->ijin,
      'alpa' => $this->alpa,
      'early' => $this->early,
      'late' => $this->late,
      'v_nama' => $this->v_nama,
      'v_nrk' => $this->v_nrk,
    ];

    return $data;
  }
}
