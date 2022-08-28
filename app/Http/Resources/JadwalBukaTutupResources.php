<?php

namespace App\Http\Resources;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class JadwalBukaTutupResources extends JsonResource
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
      'slug_path' => $this->slug_path,
      'id_jadwal' => $this->id_jadwal,
      'kode_jenis_jadwal' => $this->kode_jenis_jadwal,
      'nama_jenis_jadwal' => $this->nama_jenis_jadwal,
      'type_periode' => $this->type_periode,
      'dibuka_untuk' => $this->dibuka_untuk,
      'tahun_dibuka' => $this->tahun_dibuka,
      'tw_bulan_dibuka' => ($this->tw_bulan_dibuka) ? $this->tw_bulan_dibuka : '-',
      'tanggal_mulai' => $this->tanggal_mulai,
      'tanggal_akhir' => $this->tanggal_akhir,
      'tanggal_mulai_jbt' => GeneralHelper::dateIndoConverter($this->tanggal_mulai),
      'tanggal_akhir_jbt' => GeneralHelper::dateIndoConverter($this->tanggal_akhir),
      'status_aktif' => $this->status_aktif,
      'jenis_list_khusus' => $this->jenis_list_khusus,
      'list_khusus' => ($this->list_khusus != null) ? explode(",", $this->list_khusus) : '-'
    ];

    return $data;
  }
}
