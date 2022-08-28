<?php

namespace App\Http\Resources\Input\RencanaKinerja;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class InputJptOperasionalKhususResources extends JsonResource
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
            'id' => $this->id,
            'sasaran' => ($this->sasaran) ? $this->sasaran : '-',
            'indikator_renkin' => ($this->indikator) ? $this->indikator : '-',
            'kode_sumber' => $this->kode_sumber ? $this->kode_sumber : '-',
            'sumber_data' => $this->sumber_data ? $this->sumber_data : '-',
            'pengukuran' =>  $this->pengukuran_kinerja ? $this->pengukuran_kinerja : '-',
            'satuan' => $this->satuan ? $this->satuan : '-',
            'rumus_realisasi' =>  $this->rumus_realisasi ? $this->rumus_realisasi : '-',
            'rumus_capaian' =>  $this->rumus_capaian ? $this->rumus_capaian : '-',
            'target_tahunan' => $this->target,
            'target_tw_1' => ($this->target_tw_1 != null) ? $this->target_tw_1 : '-',
            'target_tw_2' => ($this->target_tw_2 != null) ? $this->target_tw_2 : '-',
            'target_tw_3' => ($this->target_tw_3 != null) ? $this->target_tw_3 : '-',
            'target_tw_4' => ($this->target_tw_4 != null) ? $this->target_tw_4 : '-'
        ];

        return $data;
    }
}
