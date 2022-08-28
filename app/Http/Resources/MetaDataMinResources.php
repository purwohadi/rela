<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class MetaDataMinResources extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    $temp = explode(' ', $this->rai_level_4, 2);
    $data = [
      'key' => Str::snake($this->rai_level_4),
      'value' => $this->domain_code,
      'id_metadata' => $this->domain_code
    ];
    // dd($data);

    return $data;
  }
}
