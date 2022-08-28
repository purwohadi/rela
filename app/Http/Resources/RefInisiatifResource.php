<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RefInisiatifResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'opd_pemilik' => $this->opd_pemilik,
      'aplikasi' => $this->aplikasi,
      'jenis_kesenjangan' => $this->jenis_kesenjangan,
      'domain_arsitektur' => $this->domain_arsitektur,
      'jenis_inisiatif' => $this->jenis_inisiatif,
      'deskripsi_pekerjaan' => $this->deskripsi_pekerjaan,
      'nama_inisiatif' => $this->nama_inisiatif,
      'tahun_awal' => $this->tahun_awal,
      'tahun_akhir' => $this->tahun_akhir,
      'opd_koordinator' =>$this->opd_koordinator
    ];
  }
}
