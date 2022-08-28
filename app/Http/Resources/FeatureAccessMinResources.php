<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FeatureAccessMinResources extends JsonResource
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
      // 'parent_id' => $this->i_parentid,
      'name' => $this->v_name,
      'alias' => $this->v_alias,
      'type' => $this->e_type,
      'description' => $this->v_description,
      'slug_path' => $this->slug_path,
    ];

    return $data;
  }
}
