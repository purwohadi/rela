<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FeatureAccessResources extends JsonResource
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
      'parent_id' => $this->i_parentid,
      'name' => $this->v_name,
      'alias' => $this->v_alias,
      'type' => $this->e_type,
      'description' => $this->v_description,
      'isChecked' => NULL,
      // 'created_by' => $this->v_created_by,
      // 'updated_by' => $this->v_updated_by,
      'hasChild' => !$this->children->isEmpty() ? true : false,
      'slug_path' => $this->slug_path,
    ];
    // if (!$this->children->isEmpty()) {
    //   $data['expanded'] = !$this->children->isEmpty() ? true : false;
    // }

    return $data;
  }
}
