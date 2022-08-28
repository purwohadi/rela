<?php

namespace App\Http\Resources\Input\Aktivitas;

use Illuminate\Http\Resources\Json\JsonResource;

class ReferensiResources extends JsonResource
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
      'waktu' => $this->si_waktu,
      'nama_aktivitas' => $this->v_nama_aktivitas,
      'satuan_output' => $this->v_satuan_output,
      'keterangan' => $this->v_keterangan,
    ];
  }
}
