<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DataPegawaiSimpegResources extends JsonResource
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
      'nrk' => $this->nrk,
      'nama' => $this->nama,
      'nip18' => $this->nip18,
      'pathir' => $this->pathir,
      'talhir' => $this->talhir,
      'status' => $this->status,
      'gol' => $this->gol,
      'napang' => $this->napang,
      'kd' => $this->kd,
      'lokasi_kerja' => $this->lokasi_kerja,
      'lokasi_gaji' => $this->lokasi_gaji,
      'eselon' => $this->eselon,
      'jabatan' => $this->jabatan
    ];

    return $data;
  }
}
