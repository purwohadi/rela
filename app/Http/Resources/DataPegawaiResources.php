<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DataPegawaiResources extends JsonResource
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
      'v_nama' => $this->v_nama,
      'v_nip18' => $this->v_nip18,
      'v_nrk' => $this->v_nrk,
      'v_kojab' => $this->v_kojab,
      'v_kolok' => $this->v_kolok,
      'e_kd' => $this->e_kd,
    ];

    $data['jabatan'] = $this->jabatan_pegawai;
    $data['lokasi'] = $this->nama_skpd;


    return $data;
  }
}
