<?php

namespace App\Http\Resources\Input\RencanaKinerja;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class CapaianKinerjaMinResources extends JsonResource
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
            'nip' => $this->v_nip18,
            'nama' => $this->v_nama,
            'nrk' => $this->v_nrk,
            'thbl' => $this->v_thbl,
            'kojab' => $this->v_kojab,
            'kolok' => $this->v_kolok,
            'nalok' => $this->nalok,
            'spmu' => $this->v_spmu,
            'najab' => $this->najabl,
            'eselon' => $this->v_eselon,
            'nama_eselon' => $this->nama_eselon,
            'kd' => $this->e_kd,
            'has_bawahan' => $this->has_bawahan,
            'stapeg' => $this->e_stapeg
        ];

        $pegawaiEkp = $this->pegawaiEkp()->where('v_thbl', $this->v_thbl)->first();
        $data['is_pegawai_ekp'] = $pegawaiEkp ? true : false;

        return $data;
    }
}
