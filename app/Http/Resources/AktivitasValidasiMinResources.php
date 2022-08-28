<?php

namespace App\Http\Resources;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class AktivitasValidasiMinResources extends JsonResource
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
            'nrk' => $this->nrk_bawahan,
            'nama' => $this->v_nama,
            'thbl' => GeneralHelper::thblConverter($this->v_thbl),
            'nalok' => $this->nalok,
            'najab' => $this->najabl,
            'has_rekomendasi' => (bool) $this->status,
        ];

        return $data;
    }
}
