<?php

namespace App\Http\Resources\Input\Arahan;

use App\Helpers\GeneralHelper;
use App\Http\Resources\ReferensiResources;
use Illuminate\Http\Resources\Json\JsonResource;

class GubernurResourcesMin extends JsonResource
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
      'tanggal_arahan_convert' => GeneralHelper::dateIndoConverter($this->d_tanggal_arahan),
      'permasalahan' => $this->permasalahan,
      'sumber_arahan' => $this->sumber_arahan,
      'topik' => $this->topik,
      'isi_arahan' => $this->t_isi_arahan,
      'slug_path' => $this->slug_path,
      'has_sumber_arahan' => new ReferensiResources($this->hasSumberArahan()->first()),
      'has_topik' => new TopikResources($this->hasTopik()->first()),
    ];
  }
}
