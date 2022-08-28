<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RefrensiKemendagriResources extends JsonResource
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
      'urusan' => $this->urusan,
      'bid_urusan' => $this->bid_urusan,
      'program' => $this->program,
      'kegiatan' => $this->kegiatan,
      'sub_kegiatan' => $this->sub_kegiatan,
      'nomenklatur_urusan' => $this->nomenklatur_urusan,
      'kinerja' => $this->kinerja,
      'indikator' => $this->indikator,
      'satuan' => $this->satuan,
    ];

    return $data;
  }
}
