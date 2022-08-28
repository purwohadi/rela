<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailDataInformasiResources extends JsonResource
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
      'uraian_data' => $this->uraian_data,
      'tujuan_data' => $this->tujuan_data,
      'sifat_data' => $this->sifat_data,
      'komponen_data' => $this->komponen_data,
      'jenis_data1' => $this->jenis_data1,
      'jenis_data2' => $this->jenis_data2,
      'data_owner' => $this->data_owner

    ];

    return $data;
  }
}
