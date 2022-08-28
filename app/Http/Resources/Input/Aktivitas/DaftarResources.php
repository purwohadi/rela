<?php

namespace App\Http\Resources\Input\Aktivitas;

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class DaftarResources extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    $output = [
      'slug_path' => $this->slug_path,
      'nrk' => $this->v_nrk,
      'tanggal' => $this->d_tanggal,
      'waktu_mulai' => $this->t_waktu_mulai,
      'waktu_selesai' => $this->t_waktu_selesai,
      'status_validasi' => $this->e_status_validasi,
      'keterangan' => $this->tx_keterangan,
      'volume' => $this->si_volume,
      'jenis' =>  Str::title($this->e_jenis),
      'renaksi' => null,
      'aktivitas' => null,
      'payload' => $this->createEncryptString(),
      'note' => $this->v_note,
    ];

    if ($this->renaksi) {
      $output['renaksi'] = new RenaksiResources($this->renaksi);
    }

    if ($this->aktivitas) {
      $output['aktivitas'] = new ReferensiResources($this->aktivitas);
    }

    return $output;
  }

  protected function createEncryptString()
  {
    $template = "%s;%s;%s;%s;%s;%s;%s;%s";
    $str2Compress = sprintf(
      $template,
      $this->e_jenis,
      $this->d_tanggal,
      $this->t_waktu_mulai,
      $this->t_waktu_selesai,
      $this->aktivitas->v_nama_aktivitas,
      $this->tx_keterangan,
      $this->si_volume,
      $this->e_status_validasi
    );

    return encrypt_hashid($str2Compress);
  }
}
