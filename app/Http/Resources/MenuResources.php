<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuResources extends JsonResource
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
      'id' => $this['i_id'],
      'label' => $this['v_name'],
      'alias' => $this['v_alias'],
      'icon' => $this['v_icon'],
      'parent' => $this['i_parentid'],
      'type' => $this['e_type'],
      'description' => $this['v_description'],
      'key' => $this['slug_path'],
      'route' => $this['v_route'],
      'order_no' => intval($this['i_order_no']),
    ];

    $temp = (array)$this;
    if (array_key_exists('children', $temp['resource']) && count($this['children']) > 0) {
      $data['child'] = MenuResources::collection($this['children']);
    }
    return $data;
  }
}
