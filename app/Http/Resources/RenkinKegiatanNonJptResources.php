<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RenkinKegiatanNonJptResources extends JsonResource
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
      'id_skp_detail' => $this->id_skp_detail,
      'v_id_skp' => $this->skp_id,
      'v_kegiatan' => $this->kegiatan,
      'v_quantity' => $this->quantity,
      'v_total_month' => $this->total_month,
      'v_output' => $this->output ? $this->output : $this->name,
      'v_jenis_kegiatan' => $this->jenis_kegiatan,
      'other_id1' => $this->other_id1,
      'other_id2' => $this->other_id2,
      'is_quantity_rev' => $this->is_quantity_rev,
      'is_total_month_rev' => $this->is_total_month_rev,
      'quantity_rev' => $this->quantity_rev,
      'total_month_rev' => $this->total_month_rev,
      'tw_perkin' => $this->tw_perkin,
      'tw_ksd' => $this->tw_ksd,
      'doc_name' => $this->doc_name,
      'is_kegiatan_rev' => $this->is_kegiatan_rev,
      'is_quantity_rev' => $this->is_quantity_rev,
      'is_total_month_rev' => $this->is_total_month_rev,
      'is_output_rev' => $this->is_output_rev,
      'kegiatan_rev' => $this->kegiatan_rev,
      'quantity_rev' => $this->quantity_rev,
      'total_month_rev' => $this->total_month_rev,
      'output_rev' => $this->output_rev,
      'no_insert' => ($this->is_kegiatan_rev == 1 && $this->kegiatan_rev == null) ? true : false,
    ];

    if ($this->jenis_kegiatan == 'perkin') {
      $data['v_rumus_capaian'] = null;
    } else if ($this->jenis_kegiatan == 'ksd'){
      $data['v_rumus_capaian'] = 'NORMAL';
    } else {
      $data['v_rumus_capaian'] = 'NORMAL';
    }

    if ($this->jenis_kegiatan == 'perkin') {
      $data['v_rumus_realisasi'] = null;
    } else if ($this->jenis_kegiatan == 'ksd'){
      $data['v_rumus_realisasi'] = 'ABSOLUT';
    } else {
      $data['v_rumus_realisasi'] = 'ABSOLUT';
    }

    return $data;
  }
}
