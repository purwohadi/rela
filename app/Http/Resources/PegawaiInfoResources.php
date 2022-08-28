<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PegawaiInfoResources extends JsonResource
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
      'nrk' => $this->v_nrk,
      'nama' => $this->v_nama,
      'kode' => $this->e_kd,
      'jabatan' => $this->nama_jabatan,
      'unit_kerja' => $this->lokasi_kerja,
      'thbl' => $this->v_thbl,
    ];
    $data['atasan'] = $this->atasan ? [
      'nrk' => $this->atasan->v_nrk,
      'nama' => $this->atasan->v_nama,
      'kode' => $this->atasan->e_kd,
      'jabatan' => $this->atasan->najabl,
      'unit_kerja' => $this->atasan->nalok,
      'thbl' => $this->atasan->v_thbl,
    ] : [];

    return $data;
  }
}
