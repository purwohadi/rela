<?php

namespace App\Http\Resources\Settings\Struktur;

use Illuminate\Http\Resources\Json\JsonResource;

class Lihat extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'thbl' => strtoupper($this->v_thbl),
      'nrk' => strtoupper($this->v_nrk),
      'nama' => strtoupper($this->v_nama),
      'jabatan' => "{$this->najabl} - {$this->nalok}",
      'slug_path' => $this->slug_path,
      'has_bawahan' => $this->has_bawahan,
    ];
  }
}
