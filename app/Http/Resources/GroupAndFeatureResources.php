<?php

namespace App\Http\Resources;

use App\Http\Resources\FeatureAccessMinResources;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupAndFeatureResources extends JsonResource
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
      'slug_path' => $this->slug_path,
      'nama' => $this->v_group_name,
      'status' => $this->e_status_aktif,
    ];
    $data['opd_id'] = $this->v_opd_id;
    $data['opd'] = $this->opd ? $this->opd->akronim : '';
    $data['features'] = !$this->featureGroup->isEmpty() ? $this->featureGroup->map(function ($item) {
      return $item->featureAccess ? new FeatureAccessMinResources($item->featureAccess) : [];
    }) : [];

    return $data;
  }
}
