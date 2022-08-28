<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LihatStrukturResources extends JsonResource
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
      // 'slug_path' => $this->slug_path,
      'v_nrk' => $this->v_nrk,
      'v_nama' => $this->v_nama,
      // 'v_kojab' => $this->v_kojab,
      // 'v_kolok' => $this->v_kolok,
      'bawahan' => $this->vw_bawahan,
    ];

    return $data;
  }
}
