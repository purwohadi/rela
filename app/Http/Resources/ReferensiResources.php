<?php

namespace App\Http\Resources;

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
      'key' => $this->v_key,
      'value' => $this->v_value,
      'reserve' => $this->v_reserve,
      'type' => $this->v_type,
      'slug_path' => $this->slug_path,
    ];
  }
}
