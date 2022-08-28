<?php

namespace App\Http\Resources\Input\RencanaKinerja;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class VerifikasiRealisasiResources extends JsonResource
{
    /**
    * Transform the resource into an array.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function toArray($request)
    {   
        $path_folder = null;
        if ($this->dt_created_at != null) { 
            $date_folder = explode(" ", $this->dt_created_at);
            $folder = explode("-", $date_folder[0]); 
            $path_folder = env('APP_URL').'/storage/'.$folder[0].'/'.$folder[1].'/'.$folder[2];
        }

        $data = [
            'id' => $this->i_id,
            'tahun' => $this->v_tahun,
            'kolok' => $this->kolok,
            'kojab' => $this->v_kojab,
            'perangkat_daerah' => $this->nalok,
            'nama_sumber' => $this->v_nama_sumber,
            'skpd_pengampu' => $this->v_skpd_pengampu,
            'triwulan' => $this->si_triwulan,
            'target' => ($this->f_target != null) ? $this->f_target : '-',
            'realisasi' => ($this->f_realisasi != null) ? $this->f_realisasi : '-',
            'verifikasi' => ($this->f_verifikasi != null) ? $this->f_verifikasi : '-',
            'keterangan_realisasi' => ($this->tx_keterangan_realisasi != null) ? (strlen($this->tx_keterangan_realisasi) > 50) ? substr($this->tx_keterangan_realisasi, 0, 50).'...' : $this->tx_keterangan_realisasi : '-',
            'lampiran' => $this->v_lampiran,
            'path_folder' => $path_folder,
        ];

        return $data;
    }
}
