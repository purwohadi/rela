<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DomainInfrastrukturCloudResources  extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    // $temp = explode(' ', $this->domain_code, 2);
    $data = [
      'slug_path' => $this->slug_path,
      'opd_id' => $this->opd_id,
      'rai_level_1' => $this->rai_level_1,
      'rai_level_2' => $this->rai_level_2,
      'rai_level_3' => $this->rai_level_3,
      'instansi' => $this->nama_opd,
      'deskripsi' => $this->deskripsi,
      'tipe' => $this->tipe,
      'nama_owner' => $this->nama_owner,
      'status_ownership' => $this->status_ownership,
      'unit_dev' => $this->unit_dev,
      'unit_oper' => $this->unit_oper,
      'biaya' => $this->biaya,
      'id_metadata_terkait' => $this->id_metadata_terkait,
      'id' => $this->id,
      'nama' => $this->nama,
      'domain_code' => $this->domain_code,
    ];
    return $data;
  }
}
