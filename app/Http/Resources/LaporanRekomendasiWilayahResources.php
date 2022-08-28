<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LaporanRekomendasiWilayahResources extends JsonResource
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
      'nalok' => $this->nalok,
      'najabs' => $this->najabs,
      'jumlah_aktivitas' => $this->jumlah_aktivitas,
      'sudah_verifikasi_rekomendasi' => $this->sudah_verifikasi_rekomendasi,
      'nrk_walikota' => $this->nrk_walikota,
      'nama_walikota' => $this->nama_walikota,
      'nalok_walikota' => $this->nalok_walikota,
      'najab_walikota' => $this->najab_walikota
    ];

    return $data;
  }
}
