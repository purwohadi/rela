<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ManualBookListResources extends JsonResource
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
      'type' => $this->e_type,
      'nama_judul' => $this->v_nama_judul,
      'nama_file' => $this->v_nama_file,
      'url_video' => $this->v_video ? $this->v_video : null,
      'urutan' => $this->i_order,
      'created_by' => $this->v_created_by,
      'updated_by' => $this->v_updated_by,
      'slug_path' => $this->slug_path,
      'file_book' => $this->file_book,
      'folder' => new ManualBookParentResources($this->parent),
    ];

    return $data;
  }
}
