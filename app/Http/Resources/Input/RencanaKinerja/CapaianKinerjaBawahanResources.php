<?php

namespace App\Http\Resources\Input\RencanaKinerja;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class CapaianKinerjaBawahanResources extends JsonResource
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
            'nrk_atasan' => $this->nrk_atasan,
            'nrk' => $this->nrk_bawahan,
            'nama' => $this->v_nama,
            'thbl' => $this->v_thbl,
            'eselon' => $this->eselon_bawahan,
            'kolok' => $this->kolok_bawahan,
            'nalok' => $this->nalok,
            'kojab' => $this->kojab_bawahan,
            'najab' => $this->najab,
            'kd' => $this->kd_bawahan
        ];

        return $data;
    }
}
