<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InputNonJptResources extends JsonResource
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
      // 'id' => $this->id,
      'i_id' => $this->i_id,
      'si_bulan_awal' => $this->si_bulan_awal,
      'si_bulan_akhir' => $this->si_bulan_akhir,
      'c_kd' => $this->c_kd == 'F' ? 'FUNGSIONAL' : 'STRUKTURAL',
      'v_jabatan' => $this->v_jabatan,
      'v_unit_kerja' => $this->v_unit_kerja,
      // 'e_status_proses' => $this->e_status_proses,
      'slug_path' => $this->slug_path,
      'status_proses' => $this->e_status_proses,
      'e_status_tutup_periode' => $this->e_status_tutup_periode,
      'enddate' => $this->enddate,
      'enddate_bln' => $this->enddate_bln,
      'enddate_mutasi' => $this->enddate_mutasi,
      'enddate_mutasi_bln' => $this->enddate_mutasi_bln,
      'status_approvement' => $this->status_approvement,
      'thbl_atasan' => $this->thbl_atasan,
      'nrk_atasan' => $this->nrk_atasan,
      'data_atasan' => $this->data_atasan
    ];

    if ($this->e_status_proses == 0) {
      $data['e_status_proses'] = 'MENUNGGU VERIFIKASI';
    }
    else if ($this->e_status_proses == 1) {
      $data['e_status_proses'] = 'SUDAH DIVERIFIKASI';
    }
    else if ($this->e_status_proses == 2) {
      if($this->e_status_tutup_periode==0)
      {
        $data['e_status_proses'] = 'PERIODE DITUTUP BELUM DIVERIFIKASI';
      }
      else
      {
        $data['e_status_proses'] = 'PERIODE DITUTUP';
      }
    }
    else if ($this->e_status_proses == 3) {
      $data['e_status_proses'] = 'PERUBAHAN BELUM DIVERIFIKASI';
    }
    else if ($this->e_status_proses == 4) {
      $data['e_status_proses'] = 'PERUBAHAN SUDAH DIVERIFIKASI';
    }
    else {
      $data['e_status_proses'] = 'SKP DIRESET';
    }

    return $data;
  }
}
