<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class InstansiSPLPMinResources extends JsonResource
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
      'key' => Str::snake($this->akronim),
      'opd_id' => $this->opd_id,
      'akronim' => $this->akronim,
    ];

    return $data;
  }
}
