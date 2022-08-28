<?php

namespace App\Http\Resources\Input\RencanaKinerja;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class SumberDataResources extends JsonResource
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
            'kode_sumber' => $this->v_kode_sumber,
            'nama_sumber' => $this->v_nama_sumber,
            'grup_data' => $this->v_grup_data,
            'sasaran' => $this->tx_sasaran,
            'indikator' => $this->tx_indikator,
            'pengukuran' => $this->tx_pengukuran,
            'satuan' => $this->v_satuan,
            'skpd_pengampu' => $this->v_skpd_pengampu,
            'target_tahunan' => $this->f_target_tahunan,
            'rumus_realisasi' => $this->v_rumus_realisasi,
            'rumus_capaian' => $this->v_rumus_capaian,
            'target_default_tw1' => $this->f_target_default_tw1,
            'target_default_tw2' => $this->f_target_default_tw2,
            'target_default_tw3' => $this->f_target_default_tw3,
            'target_default_tw4' => $this->f_target_default_tw4
        ];

        return $data;
    }
}
