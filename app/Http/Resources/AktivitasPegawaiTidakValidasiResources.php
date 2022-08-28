<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AktivitasPegawaiTidakValidasiResources extends JsonResource
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
      'nrk_bawahan' => $this->nrk_bawahan,
      'nama_bawahan' => $this->nama_bawahan,
      'jumlah_aktivitas' => ($this->jumlah_aktivitas) ? $this->jumlah_aktivitas : "-",
      'jumlah_belum_divalidasi' => ($this->jumlah_belum_divalidasi) ? $this->jumlah_belum_divalidasi : "-",
      'jumlah_sudah_divalidasi' => ($this->jumlah_sudah_divalidasi) ? $this->jumlah_sudah_divalidasi : "-",
      'nalok' => ($this->nalok) ? $this->nalok : "-",
      'nrk_atasan' => $this->nrk_atasan,
      'nama_atasan' => $this->nama_atasan
    ];

    return $data;
  }
}
