<?php

namespace App\Http\Resources\Input\Arahan;

use Illuminate\Http\Resources\Json\JsonResource;

class TopikResources extends JsonResource
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
      'nama_topik' => $this->v_nama_topik,
      'slug_path' => $this->slug_path,
    ];
  }
}
