<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AktivitasPegawaiBelumValidasiResources extends JsonResource
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
      'v_nrk_bawahan' => $this->v_nrk_bawahan,
      'v_nama_bawahan' => $this->v_nama_bawahan,
      'v_kojab_bawahan' => $this->v_kojab_bawahan,
      'v_eselon_bawahan' => $this->v_eselon_bawahan,
      'v_jumlah_aktivitas' => $this->v_jumlah_aktivitas,
      'v_kolok_atasan' => $this->v_kolok_atasan,
      'v_nalok_atasan' => $this->v_nalok_atasan,
      'v_nrk_atasan' => $this->v_nrk_atasan,
      'v_nama_atasan' => $this->v_nama_atasan,
      'v_kojab_atasan' => $this->v_kojab_atasan,
    ];

    return $data;
  }
}
