<?php

namespace App\Http\Resources;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class AktivitasValidasiDetailResources extends JsonResource
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
            'nrk' => $this->v_nrk,
            'thbl' => $this->v_thbl,
            'tanggal' => $this->d_tanggal,
            'tanggal_convert' => GeneralHelper::dateIndoConverter($this->d_tanggal),
            'jam' => GeneralHelper::clockConverter($this->t_waktu_mulai)."-".GeneralHelper::clockConverter($this->t_waktu_selesai),
            'indikator_renkin' => $this->v_kegiatan,
            'laporan' => $this->tx_keterangan,
            'jenis' => $this->e_jenis,
            'waktu' => $this->si_waktu,
            'volume' => $this->si_volume,
            'status_rekomendasi' => ($this->e_status_rekomendasi != null) ? $this->e_status_rekomendasi : '-',
            'status_validasi' => ($this->e_status_validasi != null) ? $this->e_status_validasi : '-'
        ];

        return $data;
    }
}
