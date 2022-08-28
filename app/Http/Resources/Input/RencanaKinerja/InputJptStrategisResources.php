<?php

namespace App\Http\Resources\Input\RencanaKinerja;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class InputJptStrategisResources extends JsonResource
{
    /**
    * Transform the resource into an array.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function toArray($request)
    {
        $pengukuran_kinerja = '-';
        $other_id1 = '-';
        $other_id2 = '-';
        $anggaran = '-';
        if (isset($this->pengukuran_kinerja)) if ($this->pengukuran_kinerja) $pengukuran_kinerja = $this->pengukuran_kinerja;
        if (isset($this->other_id1)) if ($this->other_id1) $other_id1 = $this->other_id1;
        if (isset($this->other_id2)) if ($this->other_id2) $other_id2 = $this->other_id2;
        if (isset($this->anggaran)) if ($this->anggaran) $anggaran = $this->anggaran;
        
        $data = [
            'sasaran' => ($this->sasaran) ? $this->sasaran : '-',
            'indikator_renkin' => ($this->indikator) ? $this->indikator : '-',
            'sumber_data' => isset($this->nomor_ksd) ? 'e-Monev KSD' : 'Perjanjian Kinerja',
            'pengukuran' =>  $pengukuran_kinerja,
            'target_tahunan' => $this->target,
            'target_tw_1' => ($this->target_tw_1 != null) ? $this->target_tw_1 : '-',
            'target_tw_2' => ($this->target_tw_2 != null) ? $this->target_tw_2 : '-',
            'target_tw_3' => ($this->target_tw_3 != null) ? $this->target_tw_3 : '-',
            'target_tw_4' => ($this->target_tw_4 != null) ? $this->target_tw_4 : '-',
            'keterangan' => ($this->satuan) ? $this->satuan : '-',
            'rumus_capaian' => ($this->rumus_capaian) ? $this->rumus_capaian : '-',
            'rumus_realisasi' => ($this->rumus_realisasi) ? $this->rumus_realisasi : '-',
            'other_id1' => $other_id1,
            'other_id2' => $other_id2,
            'anggaran' => $anggaran
        ];

        return $data;
    }
}
