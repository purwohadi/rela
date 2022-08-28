<?php

namespace App\Http\Resources;

use App\Models\HitungAbsensi;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResources extends JsonResource
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
      "slug_path" => $this->slug_path,
      "isi_pengumuman" => $this->tx_isi_pengumuman,
      "banner" => $this->banner,
      "has_banner_image" => $this->has_banner_image,
    ];

    return $data;
  }
}
