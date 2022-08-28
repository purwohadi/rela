<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupNFeatureResources extends JsonResource
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
      'slug_path' => $this->slug_path,
      'nama' => $this->v_group_name,
      'status' => $this->e_status_aktif,
      'opd_id' => $this->v_opd_id
    ];

    $data['features'] = !$this->featureGroup->isEmpty() ? $this->featureGroup->map(function ($item) {
      return $item;
    }) : [];

    return $data;
  }
}
