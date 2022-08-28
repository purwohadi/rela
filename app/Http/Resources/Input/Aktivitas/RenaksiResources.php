<?php

namespace App\Http\Resources\Input\Aktivitas;

use Illuminate\Http\Resources\Json\JsonResource;
class RenaksiResources extends JsonResource

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
      'slug_path' => $this->slug_path,
      'jenis_kegiatan' => $this->v_jenis_kegiatan,
      'kegiatan' => $this->v_kegiatan,
      'output' => $this->v_output,
      'quantity' => $this->v_quantity,
      'rumus_capaian' => $this->v_rumus_capaian,
      'rumus_realisasi' => $this->v_rumus_realisasi,
      'total_month' => $this->v_total_month,
    ];
  }
}
