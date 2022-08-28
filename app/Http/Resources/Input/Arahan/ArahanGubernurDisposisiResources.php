<?php

namespace App\Http\Resources\Input\Arahan;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ArahanGubernurDisposisiResources extends JsonResource
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
      'slug_path' => $this->slug_path,
      'id_arahan_disposisi' => $this->id_arahan_disposisi,
      'kolok' => $this->kolok,
      'perangkat_daerah' => $this->nalok,
      'kojab' => $this->kojab,
      'jabatan' => $this->najab,
      'estimasi_selesai_skpd' => $this->estimasi_selesai_skpd,
      'target_selesai' => $this->target_selesai,
      'target_estimasi_convert' => ($this->estimasi_selesai_skpd != null) ? GeneralHelper::dateIndoConverter($this->estimasi_selesai_skpd) : "-",
      'kriteria_ketuntasan' => $this->kriteria_arahan,
      'keterangan_nonaktif' => $this->keterangan_nonaktif,
      'jenis_prioritas' => $this->kategori,
      'status_disposisi' => $this->status_dispo,
      'status_disposisi_ref' => $this->status_dispo_ref,
      'status_tl' => $this->status_tl_skpd,
      'status_tl_ref' => $this->status_tl_skpd_ref
    ];
  }
}
