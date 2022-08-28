<?php

namespace App\Http\Resources\Input\RencanaKinerja;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class CapaianEkpVariabelResources extends JsonResource
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
      'v_kode_va' => $this->v_kode_va,
      'v_kode_jabatan' => $this->v_kode_jabatan,
      'v_nama_variabel' => $this->v_nama_variabel,
      'si_bobot' => $this->si_bobot,
      'v_urutan' => $this->v_urutan,
      'v_kode_variabel_ekp' => $this->v_kode_variabel_ekp,
      'v_status_aktif' => $this->v_status_aktif,
    ];

    // $capaian_nilai = $this->capaianNilai;
    // $data['capaian_nilai'] = $capaian_nilai ? $capaian_nilai : null;

    return $data;
  }
}
