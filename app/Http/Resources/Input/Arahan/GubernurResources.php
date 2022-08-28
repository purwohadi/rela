<?php

namespace App\Http\Resources\Input\Arahan;

use App\Http\Resources\ReferensiResources;
use Illuminate\Http\Resources\Json\JsonResource;

class GubernurResources extends JsonResource
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
      'tanggal_arahan' => $this->d_tanggal_arahan,
      'status_disposisi' => ucwords($this->e_status_disposisi),
      'sumber_arahan' => $this->sumber_arahan,
      'topik' => $this->topik,
      'permasalahan' => $this->permasalahan,
      'isi_arahan' => $this->t_isi_arahan,
      'jumlah_disposisi' => ($this->si_jumlah_disposisi == null) ? 0 : $this->si_jumlah_disposisi,
      'slug_path' => $this->slug_path,
      'has_sumber_arahan' => new ReferensiResources($this->hasSumberArahan()->first()),
      'has_topik' => new TopikResources($this->hasTopik()->first()),
    ];
  }
}
