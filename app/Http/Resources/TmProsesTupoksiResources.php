<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TmProsesTupoksiResources extends JsonResource
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
      'num_rows' => $this->num_rows,
      'tupoksi' =>  $this->nama_unit ? $this->nama_unit . ' - ' . $this->tupoksi : 'Tingkat Biro/Badan/Dinas' . ' - ' . $this->tupoksi,
      'tu_ref' => $this->tu_ref,
      'tupoksi_desc' => $this->nama_unit ? $this->nama_unit . ' - ' . $this->id_entitas . ' - ' . $this->tupoksi_desc : 'Tingkat Biro/Badan/Dinas' . ' - ' . $this->id_entitas . ' - ' . $this->tupoksi_desc,
      'id_entitas' => $this->id_entitas,
    ];

    return $data;
  }
}
