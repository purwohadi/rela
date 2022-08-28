<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ManualBookAllResources extends JsonResource
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
      'parent_id' => $this->i_parent_id,
      'type' => $this->e_type,
      'name' => $this->v_nama_judul,
      'nama_file' => $this->v_nama_file,
      'url_video' => $this->v_video ? $this->v_video : null,
      // 'urutan' => $this->i_order,
      // 'created_by' => $this->v_created_by,
      // 'updated_by' => $this->v_updated_by,
      // 'expanded' => !$this->children->isEmpty() ? true : false,
      // 'children' => ManualBookAllResources::collection($this->children),
      'hasChild' => !$this->children->isEmpty() ? true : false,
      'slug_path' => $this->slug_path,
      'file_book' => $this->file_book,
      // 'folder' => new ManualBookParentResources($this->parent)
    ];

    if(!$this->children->isEmpty()) {
      $data['childrens'] = ManualBookAllResources::collection($this->children);
    }

    return $data;
  }
}
