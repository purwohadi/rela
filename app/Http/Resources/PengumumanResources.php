<?php

namespace App\Http\Resources;

use App\Models\HitungAbsensi;
use Illuminate\Http\Resources\Json\JsonResource;

class PengumumanResources extends JsonResource
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
      "slug_path" => $this->slug_path,
      "isi_pengumuman" => $this->tx_isi_pengumuman,
      "created_by" => $this->v_created_by,
      // "created_at" => $this->dt_created_at->format('Y-m-d'),
      "created_at" => date('Y-m-d', strtotime($this->dt_created_at)),
    ];

    return $data;
  }
}
