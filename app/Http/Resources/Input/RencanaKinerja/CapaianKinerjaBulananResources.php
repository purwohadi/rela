<?php

namespace App\Http\Resources\Input\RencanaKinerja;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class CapaianKinerjaBulananResources extends JsonResource
{
    /**
    * Transform the resource into an array.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function toArray($request)
    {
        $nama_eselon = ($this->nama_eselon) ? $this->nama_eselon : "NON ESELON";
        $data = [
            'tahun' => ($this->tahun_renkin) ? $this->tahun_renkin : '-',
            'bulan' => \Carbon\Carbon::createFromFormat('m', $this->bulan_renkin)->translatedFormat('F'),
            'nrk' => $this->v_nrk,
            'kojab' => $this->kojab_renkin,
            'kolok' => $this->kolok_renkin,
            'jabatan_lokasi_kerja_eselon' => $this->najab_renkin." - ".$this->nalok_renkin." - ".$nama_eselon,
            'capaian' => $this->persen_capaian,
            'kd' => $this->kd_renkin
        ];

        return $data;
    }
}
