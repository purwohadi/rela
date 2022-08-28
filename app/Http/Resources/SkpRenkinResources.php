<?php

namespace App\Http\Resources;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class SkpRenkinResources extends JsonResource
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
      'nrk' => $this->v_nrk,
      'jabatan' => $this->v_jabatan,
      'unit_kerja' => $this->v_unit_kerja,
      'mutasi_berakhir' => $this->enddate_mutasi_l ? GeneralHelper::dateOnlyIndoConverter($this->enddate_mutasi_l) : null,
      'enddate' => $this->enddate,
      'enddate_mutasi' => $this->enddate_mutasi,
      'status_proses' => $this->e_status_proses,
      'status_tutup_periode' => $this->e_status_tutup_periode,
      'status_approvement' => $this->status_approvement
    ];

    return $data;
  }
}
