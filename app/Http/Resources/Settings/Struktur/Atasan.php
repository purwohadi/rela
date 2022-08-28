<?php

namespace App\Http\Resources\Settings\Struktur;

use Illuminate\Http\Resources\Json\JsonResource;

class Atasan extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    $mapped = [
      'thbl' => strtoupper($this->v_thbl),
      'nrk' => strtoupper($this->v_nrk),
      'nama' => strtoupper($this->v_nama),
      'kojab' => strtoupper($this->v_kojab),
      'kolok' => strtoupper($this->v_kolok),
      'spmu' => strtoupper($this->v_spmu),
      'is_bko' => $this->e_bko == '0' ? false : true,
      'jabatan' => $this->jabatan_pegawai
    ];

    return $mapped;
  }
}
