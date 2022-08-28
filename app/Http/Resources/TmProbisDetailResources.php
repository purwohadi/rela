<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class TmProbisDetailResources extends JsonResource
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
      'slug_path' => $this->slug_path,
      'proses_id' => $this->proses_id,
      'key' => Str::snake($this->probis),
      'probis' => $this->probis ." ".$this->nomenklatur,
    ];
    return $data;
  }
}
