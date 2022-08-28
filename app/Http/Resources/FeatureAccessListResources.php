<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FeatureAccessListResources extends JsonResource
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
      // 'id' => $this->i_id,
      'parent_id' => $this->i_parentid,
      'name' => $this->v_name,
      'alias' => $this->v_alias,
      'type' => $this->e_type,
      'description' => $this->v_description,
      'slug_path' => $this->slug_path,
      'route' => $this->v_route,
      'params' => $this->v_params,
      'icon' => $this->v_icon,
      'order' => $this->i_order_no,
    ];

    $parent = $this->parent()->first();
    $data['parent'] = $parent ? $parent->v_name : null;

    return $data;
  }
}
