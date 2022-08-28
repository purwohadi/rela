<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DashboardArahanGubResources extends JsonResource
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
      'opd' => $this->nalokl,
      'target_selesai' => $this->d_batas_perpanjangan ? $this->d_batas_perpanjangan : $this->d_estimasi_skpd,
      // 'e_status_tl_skpd' => $this->e_status_tl_skpd,
    ];

    $status_tl = $this->hasStatusTLSkpd()->first();
    $data['e_status_tl_skpd'] = $status_tl ? $status_tl->v_value : null;

    return $data;
  }
}
