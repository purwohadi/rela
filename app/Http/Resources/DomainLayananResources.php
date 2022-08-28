<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DomainLayananResources  extends JsonResource
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
      'id' => $this->id,
      'layanan_id' => $this->layanan_id,
      'fungsi_layanan' => $this->fungsi_layanan,
      'pelaksana_level1' => $this->pelaksana_level1,
      'pelaksana_level2' => $this->pelaksana_level2,
      'target_layanan' => $this->target_layanan,
      'unit_delegasi' => $this->unit_delegasi,
    ];

    return $data;
  }
}
