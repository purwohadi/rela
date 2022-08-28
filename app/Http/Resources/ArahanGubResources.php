<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArahanGubResources extends JsonResource
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
      'd_tanggal_arahan' => $this->d_tanggal_arahan,
      't_isi_arahan' => $this->t_isi_arahan,
      'e_status_disposisi' => $this->e_status_disposisi,
      'si_jumlah_disposisi' => $this->si_jumlah_disposisi,
      'e_status_aktif' => $this->e_status_aktif,
      'permasalahan' => $this->permasalahan,
      'dt_created_at' => $this->dt_created_at,
    ];
    $sumberArahan = $this->hasSumberArahan()->first();
    $topik = $this->hasTopik()->first();

    $data['v_sumber_arahan'] = $sumberArahan ? $sumberArahan->v_value : null;
    $data['topik'] = $topik ? $topik : null;


    return $data;
  }
}
