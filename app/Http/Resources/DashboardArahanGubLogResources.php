<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DashboardArahanGubLogResources extends JsonResource
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
      'id_arahan' => $this->i_id_arahan,
      'id_disposisi' => $this->i_id_disposisi,
      'keterangan' => $this->tx_keterangan
    ];

    return $data;
  }
}
