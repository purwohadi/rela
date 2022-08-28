<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AktivitasMinResources extends JsonResource
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
      'd_tanggal' => $this->d_tanggal,
      'laporan' => $this->laporan,
      't_waktu_mulai' => $this->t_waktu_mulai,
      't_waktu_selesai' => $this->t_waktu_selesai,
      'si_volume' => $this->si_volume,
      'e_status_validasi' => $this->e_status_validasi,
      'slug_path' => $this->slug_path,
    ];

    $aktivitas = $this->aktivitas;
    $data['aktivitas'] = $aktivitas ? [
      'v_nama_aktivitas' => $aktivitas->v_nama_aktivitas,
      'si_waktu' => $aktivitas->si_waktu,
      'slug_path' => $aktivitas->slug_path,
    ] : null ;


    return $data;
  }
}
