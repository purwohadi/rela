<?php

namespace App\Http\Resources\Input\RencanaKinerja;

use Illuminate\Http\Resources\Json\JsonResource;

class ValidasiRealisasiResources extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    $flag_validasi = false;

    if ($this->v_kode_sumber == "tlhp" || $this->v_grup_data == "khusus") {
      if ($this->f_realisasi != null) {
        $flag_validasi = true;
      } else {
        $flag_validasi = false;
      }
    } else {
      $flag_validasi = false;
    }

    $data = [
      'id' => $this->id_renkin,
      'kolok' => $this->v_kolok,
      'kojab' => $this->v_kojab,
      'triwulan' => $this->si_triwulan,
      'kode_sumber' => $this->v_kode_sumber,
      'nama_sumber' => $this->v_nama_sumber,
      'grup_data' => $this->v_grup_data,
      'indikator' => $this->tx_indikator,
      'target' => ($this->f_target != null) ? $this->f_target : '-',
      'realisasi' => ($this->f_realisasi != null) ? $this->f_realisasi : '-',
      'verifikasi' => ($this->f_verifikasi != null) ? $this->f_verifikasi : '-',
      'validasi' => ($this->f_validasi != null) ? $this->f_validasi : '-',
      'capaian' => ($this->f_capaian != null) ? $this->f_capaian : '-',
      'lampiran' => $this->v_lampiran,
      'keterangan_realisasi' => ($this->tx_keterangan_realisasi != null) ? (strlen($this->tx_keterangan_realisasi) > 50) ? substr($this->tx_keterangan_realisasi, 0, 50) . '...' : $this->tx_keterangan_realisasi : '-',
      'keterangan_validasi' => ($this->tx_keterangan_validasi != null) ? (strlen($this->tx_keterangan_validasi) > 50) ? substr($this->tx_keterangan_validasi, 0, 50) . '...' : $this->tx_keterangan_validasi : '-',
      'flag_validasi' => $flag_validasi,
      'file_lampiran' => $this->file_lampiran,
    ];

    return $data;
  }
}
