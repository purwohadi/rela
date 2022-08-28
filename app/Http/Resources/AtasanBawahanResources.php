<?php

namespace App\Http\Resources;

use App\Models\AtasanBawahan;
use Illuminate\Http\Resources\Json\JsonResource;

class AtasanBawahanResources extends JsonResource
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
      'kojab_bawahan' => $this->v_kojab_bawahan,
      'kolok_bawahan' => $this->v_kolok_bawahan,
      'spmu_bawahan' => $this->v_spmu_bawahan,
      'kojab_atasan' => $this->v_kojab_atasan,
      'kolok_atasan' => $this->v_kolok_atasan,
      'spmu_atasan' => $this->v_spmu_atasan,
      'najab_bawahan' => $this->v_kojab_bawahan.' - '.$this->najab_bawahan,
      'najab_atasan' => $this->v_kojab_atasan.' - '.$this->najab_atasan,
      'nalok_bawahan' => $this->v_kolok_bawahan.' - '.$this->nalok_bawahan,
      'nalok_atasan' => $this->v_kolok_atasan.' - '.$this->nalok_atasan,
      'nama_spmu_bawahan' => $this->v_spmu_bawahan.' - '.$this->nama_spmu_bawahan,
      'nama_spmu_atasan' => $this->v_spmu_atasan.' - '.$this->nama_spmu_atasan,
    ];

    return $data;
  }
}
