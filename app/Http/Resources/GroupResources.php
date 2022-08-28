<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResources extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    // return parent::toArray($request);

    $data = [
      'id' => $this->i_id,
      'slug_path' => $this->slug_path,
      'nama' => $this->v_group_name,
      'status' => $this->e_status_aktif,
      'opd_id' => $this->v_opd_id
    ];

    return $data;
  }
}
