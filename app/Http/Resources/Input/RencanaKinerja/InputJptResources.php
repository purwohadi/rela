<?php

namespace App\Http\Resources\Input\RencanaKinerja;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class InputJptResources extends JsonResource
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
            'id' => $this->i_id,
            'sasaran' => $this->tx_sasaran,
            'indikator_renkin' => $this->tx_indikator,
            'pengukuran' => $this->tx_pengukuran,
            'kode_sumber' => $this->v_kode_sumber,
            'grup_data' => $this->v_grup_data,
            'nama_sumber' => $this->v_nama_sumber,
            'target_tahunan' => $this->f_target_tahunan,
            'target_tw_1' => ($this->target_tw_1 != null) ? $this->target_tw_1 : '-',
            'target_tw_2' => ($this->target_tw_2 != null) ? $this->target_tw_2 : '-',
            'target_tw_3' => ($this->target_tw_3 != null) ? $this->target_tw_3 : '-',
            'target_tw_4' => ($this->target_tw_4 != null) ? $this->target_tw_4 : '-',
            'realisasi_tw_1' => ($this->realisasi_tw_1 != null) ? $this->realisasi_tw_1 : '-',
            'realisasi_tw_2' => ($this->realisasi_tw_2 != null) ? $this->realisasi_tw_2 : '-',
            'realisasi_tw_3' => ($this->realisasi_tw_3 != null) ? $this->realisasi_tw_3 : '-',
            'realisasi_tw_4' => ($this->realisasi_tw_4 != null) ? $this->realisasi_tw_4 : '-',
            'validasi_tw_1' => ($this->validasi_tw_1 != null) ? $this->validasi_tw_1 : '-',
            'validasi_tw_2' => ($this->validasi_tw_2 != null) ? $this->validasi_tw_2 : '-',
            'validasi_tw_3' => ($this->validasi_tw_3 != null) ? $this->validasi_tw_3 : '-',
            'validasi_tw_4' => ($this->validasi_tw_4 != null) ? $this->validasi_tw_4 : '-',
            'keterangan_realisasi_tw_1' => ($this->keterangan_realisasi_tw_1 != null) ? $this->keterangan_realisasi_tw_1 : '-',
            'keterangan_realisasi_tw_2' => ($this->keterangan_realisasi_tw_2 != null) ? $this->keterangan_realisasi_tw_2 : '-',
            'keterangan_realisasi_tw_3' => ($this->keterangan_realisasi_tw_3 != null) ? $this->keterangan_realisasi_tw_3 : '-',
            'keterangan_realisasi_tw_4' => ($this->keterangan_realisasi_tw_4 != null) ? $this->keterangan_realisasi_tw_4 : '-',
            'lampiran_tw_1' => ($this->lampiran_tw_1 != null) ? $this->lampiran_tw_1 : '-',
            'lampiran_tw_2' => ($this->lampiran_tw_2 != null) ? $this->lampiran_tw_2 : '-',
            'lampiran_tw_3' => ($this->lampiran_tw_3 != null) ? $this->lampiran_tw_3 : '-',
            'lampiran_tw_4' => ($this->lampiran_tw_4 != null) ? $this->lampiran_tw_4 : '-',
            'created_at_1' => ($this->created_at_1 != null) ? $this->created_at_1 : '-',
            'created_at_2' => ($this->created_at_2 != null) ? $this->created_at_2 : '-',
            'created_at_3' => ($this->created_at_3 != null) ? $this->created_at_3 : '-',
            'created_at_4' => ($this->created_at_4 != null) ? $this->created_at_4 : '-',  
            'updated_at_1' => ($this->updated_at_1 != null) ? $this->updated_at_1 : '-',
            'updated_at_2' => ($this->updated_at_2 != null) ? $this->updated_at_2 : '-',
            'updated_at_3' => ($this->updated_at_3 != null) ? $this->updated_at_3 : '-',
            'updated_at_4' => ($this->updated_at_4 != null) ? $this->updated_at_4 : '-'  
        ];

        return $data;
    }
}
