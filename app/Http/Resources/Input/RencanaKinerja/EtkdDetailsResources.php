<?php

namespace App\Http\Resources\Input\RencanaKinerja;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class EtkdDetailsResources extends JsonResource
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
      'att_code' => $this->att_code,
      'value' => $this->value,
    ];

    return $data;
  }
}
