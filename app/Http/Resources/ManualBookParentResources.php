<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ManualBookParentResources extends JsonResource
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
      'id' => $this->i_id,
      'type' => $this->e_type,
      'nama_folder' => $this->v_nama_judul,
    ];
    return $data;
  }
}
