<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RefrensiTupoksiResources extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    // dd($this->nama_unit);
    $data = [
      'slug_path' => $this->slug_path,
      'id_entitas' => $this->id_entitas,
      'ass_sekda' => '-',
      'tipe_entitas' => '-',
      'nama_opd' => $this->nama_opd,
      'nama_unit' => $this->nama_unit,
      'upt' => '-',
      'tupoksi' => $this->tupoksi,
      'tupoksi_desc' => $this->tupoksi_desc,
      'tu_ref' => $this->tu_ref,
    ];

    return $data;
  }
}
