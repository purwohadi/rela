<?php

namespace App\Http\Resources\Input\RencanaKinerja;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ValidasiRealisasiListResources extends JsonResource
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
            'nrk_bawahan' => $this->nrk_bawahan,
            'nama_bawahan' => $this->nama_bawahan,
            'eselon_bawahan' => $this->eselon_bawahan,
            'v_thbl' => $this->v_thbl,
            'nip_bawahan' => $this->nip_bawahan,
            'kojab_bawahan' => $this->kojab_bawahan,
            'najab_bawahan' => $this->najab_bawahan,
            'kolok_bawahan' => $this->kolok_bawahan,
            'nalok_bawahan' => $this->nalok_bawahan,
            'jumlah_target' => $this->jumlah_target,
            'jumlah_harus_validasi' => $this->jumlah_harus_validasi,
            'jumlah_belum_validasi' => $this->jumlah_belum_validasi
        ];

        return $data;
    }
}
