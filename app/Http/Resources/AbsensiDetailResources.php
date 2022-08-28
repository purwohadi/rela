<?php

namespace App\Http\Resources;

use App\Models\HitungAbsensi;
use Illuminate\Http\Resources\Json\JsonResource;

class AbsensiDetailResources extends JsonResource
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
      // 'thbl' => $this->thbl,
      'v_nama_status' => $this->v_nama_status,
      'e_jenis_status' => $this->e_jenis_status,
      // 'si_menit_penambah' => $this->si_menit_penambah,
      // 'si_menit_pengurang' => $this->si_menit_pengurang,
      'value' => $this->value,
      // 'alpa' => $this->alpa,
      // 'pulang_cepat' => $this->early,
      // 'terlambat' => $this->late,
      // 'ijin' => $this->ijin,
    ];
    return $data;
  }
}
