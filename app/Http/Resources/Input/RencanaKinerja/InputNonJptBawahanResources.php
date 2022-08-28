<?php

namespace App\Http\Resources\Input\RencanaKinerja;

use Illuminate\Http\Resources\Json\JsonResource;

class InputNonJptBawahanResources extends JsonResource
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
      'id' => $this->i_id,
      'nrk_bawahan' => $this->nrk_bawahan,
      'v_nama' => $this->v_nama,
      'v_jabatan' => $this->v_jabatan,
      'v_unit_kerja' => $this->v_unit_kerja,
      'v_tahun' => $this->v_tahun,
      'si_bulan_awal' => $this->si_bulan_awal,
      'si_bulan_akhir' => $this->si_bulan_akhir,
      'slug_path' => $this->slug_path,
      'e_status_tutup_periode' => $this->e_status_tutup_periode,
    ];

    if ($this->e_status_proses == 0) {
      $data['e_status_proses'] = 'MENUNGGU VERIFIKASI';
    } else if ($this->e_status_proses == 1) {
      $data['e_status_proses'] = 'SUDAH DIVERIFIKASI';
    } else if ($this->e_status_proses == 2) {
      if($this->e_status_tutup_periode==0)
      {
        $data['e_status_proses'] = 'PERIODE DITUTUP BELUM DIVERIFIKASI';
      }
      else
      {
        $data['e_status_proses'] = 'PERIODE DITUTUP';
      }
    } else if ($this->e_status_proses == 3) {
      $data['e_status_proses'] = 'PERUBAHAN BELUM DIVERIFIKASI';
    } else if ($this->e_status_proses == 4) {
      $data['e_status_proses'] = 'PERUBAHAN SUDAH DIVERIFIKASI';
    } else {
      $data['e_status_proses'] = 'SKP DIRESET';
    }

    return $data;
  }
}
