<?php

namespace App\Http\Resources\Settings\Struktur;

use Illuminate\Http\Resources\Json\JsonResource;

class Pelaksana extends JsonResource
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
      'thbl' => $this->thbl,
      'nrk' => $this->nrk,
      'nama' => $this->nama,
      'kojab' => $this->kojab,
      'kolok' => $this->kolok,
      'spmu' => $this->spmu,
      'stapeg' => $this->stapeg,
      'is_bko' => $this->bko == '0' ? false : true,
      'atasan' => null
    ];

    if (!is_null($this->atasan_kojab)) {
      $data['atasan'] = [
        'nrk' => $this->atasan_nrk,
        'nama' => $this->atasan_nama,
        'kojab' => $this->atasan_kojab,
        'kolok' => $this->atasan_kolok,
        'spmu' => $this->atasan_spmu,
        'jabatan' => $this->atasan_jabatan
      ];
    }

    return $data;
  }
}
