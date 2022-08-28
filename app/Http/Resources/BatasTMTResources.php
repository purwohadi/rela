<?php

namespace App\Http\Resources;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class BatasTMTResources extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    $tangal_update = ($this->dt_updated_at == null) ? $this->dt_created_at : $this->dt_updated_at;
    $data = [
      'id' => $this->v_tahun.'-'.$this->si_bulan,
      'tahun' => $this->v_tahun,
      'bulan' => $this->si_bulan,
      'bulan_idn' => \Carbon\Carbon::createFromFormat('m', $this->si_bulan)->translatedFormat('F'),
      'batas_tmt' => $this->d_batas_tmt,
      'batas_tmt_convert' => ($this->d_batas_tmt == null) ? '-' : GeneralHelper::dateIndoConverter($this->d_batas_tmt),
      'user_update' => ($this->v_updated_by == null) ? $this->v_created_by : $this->v_updated_by,
      'tanggal_update' => $tangal_update,
      'tanggal_update_convert' => ($tangal_update == null) ? '-' : GeneralHelper::dateIndoConverter($tangal_update),
    ];

    return $data;
  }
}
