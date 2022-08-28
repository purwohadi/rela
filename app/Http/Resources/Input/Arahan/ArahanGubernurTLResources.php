<?php

namespace App\Http\Resources\Input\Arahan;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ArahanGubernurTLResources extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    $batas = $this->d_batas_perpanjangan ? $this->d_batas_perpanjangan : $this->d_estimasi_skpd;
    $check = \Carbon\Carbon::parse($this->d_tgl_selesai_tl)->isAfter($batas);
    $diff = $check ? \Carbon\Carbon::parse($batas)->diffInDays($this->d_tgl_selesai_tl) : null;
    return [
      'slug_path' =>  $this->slug_path,
      'i_id' => $this->i_id,
      'i_id_arahan' => $this->i_id_arahan,
      'kolok' => $this->kolok,
      'd_tanggal_arahan' => $this->d_tanggal_arahan,
      't_isi_arahan' => $this->t_isi_arahan,
      'd_estimasi_skpd' => $this->d_estimasi_skpd ,
      'd_batas_perpanjangan' => $this->d_batas_perpanjangan,
      'd_target_selesai' => $this->d_target_selesai,
      'd_tgl_selesai_tl' => $this->d_tgl_selesai_tl,
      'status_tl' => [
        'code' => $this->status_tl_code,
        'is_late' => $this->status_tl_code == 3 ? $check ? true : false : null,
        'status' => $this->e_status_tl_skpd,
        'detail' => $diff
      ],
      'e_status_tl_skpd' => $this->e_status_tl_skpd,
      'e_status_validasi' => $this->e_status_validasi,
      'e_status_ubah_target' => $this->e_status_ubah_target,
    ];
  }
}
