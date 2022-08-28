<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SkpMinResources extends JsonResource
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
      'id' => $this->id,
      'startdate' => $this->startdate,
      'enddate' => $this->enddate,
      'enddate_mutasi' => $this->enddate_mutasi,
      'nrk' => $this->nrk,
      'jabatan' => $this->jabatan,
      'unit_kerja' => $this->unit_kerja,
      'kolok' => $this->kolok,
      'kojab' => $this->kojab,
      'kd' => $this->kd,
    ];

    return $data;
  }
}
