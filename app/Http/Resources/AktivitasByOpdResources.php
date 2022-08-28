<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AktivitasByOpdResources extends JsonResource
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
      'v_nrk' => $this->v_nrk,
      'v_nama' => $this->v_nama,
      'v_kojab' => $this->v_kojab,
      'v_kolok' => $this->v_kolok,
    ];

    $data['jabatan'] = $this->jabatan_pegawai;
    $data['lokasi'] = $this->nama_skpd;

    return $data;
  }
}
