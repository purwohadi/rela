<?php

namespace App\Http\Resources\Input\RencanaKinerja;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class InputJptMinResources extends JsonResource
{
    /**
    * Transform the resource into an array.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function toArray($request)
    {   
        $path_folder_1 = null;
        $path_folder_2 = null;
        $path_folder_3 = null;
        $path_folder_4 = null;
        if ($this->created_at_1 != null) { 
            $date_folder_1 = explode(" ", $this->created_at_1);
            $folder_1 = explode("-", $date_folder_1[0]); 
            $path_folder_1 = env('APP_URL').'/storage/'.$folder_1[0].'/'.$folder_1[1].'/'.$folder_1[2];
        }

        if ($this->created_at_2 != null) { 
            $date_folder_2 = explode(" ", $this->created_at_2);
            $folder_2 = explode("-", $date_folder_2[0]); 
            $path_folder_2 = env('APP_URL').'/storage/'.$folder_2[0].'/'.$folder_2[1].'/'.$folder_2[2];
        }

        if ($this->created_at_3 != null) { 
            $date_folder_3 = explode(" ", $this->created_at_3);
            $folder_3 = explode("-", $date_folder_3[0]); 
            $path_folder_3 = env('APP_URL').'/storage/'.$folder_3[0].'/'.$folder_3[1].'/'.$folder_3[2];
        }

        if ($this->created_at_4 != null) { 
            $date_folder_4 = explode(" ", $this->created_at_4);
            $folder_4 = explode("-", $date_folder_4[0]); 
            $path_folder_4 = env('APP_URL').'/storage/'.$folder_4[0].'/'.$folder_4[1].'/'.$folder_4[2];
        }
        
        $data = [
            'id' => $this->i_id,
            'indikator_renkin' => ($this->tx_indikator) ? $this->tx_indikator : '-',
            'kode_sumber' => ($this->v_kode_sumber) ? $this->v_kode_sumber : '-',
            'grup_data' => ($this->v_grup_data) ? $this->v_grup_data : '-',
            'nama_sumber' => ($this->v_nama_sumber) ? $this->v_nama_sumber : '-',
            'rumus_realisasi' => ($this->v_rumus_realisasi) ? $this->v_rumus_realisasi : '-',
            'rumus_capaian' => ($this->v_rumus_capaian) ? $this->v_rumus_capaian : '-',
            'satuan' => ($this->v_satuan) ? $this->v_satuan : '-',
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
            'keterangan_realisasi_tw_1' => ($this->tx_keterangan_realisasi_tw_1) ? $this->tx_keterangan_realisasi_tw_1 : '-',
            'keterangan_realisasi_tw_2' => ($this->tx_keterangan_realisasi_tw_2) ? $this->tx_keterangan_realisasi_tw_2 : '-',
            'keterangan_realisasi_tw_3' => ($this->tx_keterangan_realisasi_tw_3) ? $this->tx_keterangan_realisasi_tw_3 : '-',
            'keterangan_realisasi_tw_4' => ($this->tx_keterangan_realisasi_tw_4) ? $this->tx_keterangan_realisasi_tw_4 : '-',
            'lampiran_tw_1' => ($this->v_lampiran_tw_1) ? $this->v_lampiran_tw_1 : '-',
            'lampiran_tw_2' => ($this->v_lampiran_tw_2) ? $this->v_lampiran_tw_2 : '-',
            'lampiran_tw_3' => ($this->v_lampiran_tw_3) ? $this->v_lampiran_tw_3 : '-',
            'lampiran_tw_4' => ($this->v_lampiran_tw_4) ? $this->v_lampiran_tw_4 : '-',
            'keterangan_validasi_tw_1' => ($this->tx_keterangan_validasi_tw_1) ? $this->tx_keterangan_validasi_tw_1 : '-',
            'keterangan_validasi_tw_2' => ($this->tx_keterangan_validasi_tw_2) ? $this->tx_keterangan_validasi_tw_2 : '-',
            'keterangan_validasi_tw_3' => ($this->tx_keterangan_validasi_tw_3) ? $this->tx_keterangan_validasi_tw_3 : '-',
            'keterangan_validasi_tw_4' => ($this->tx_keterangan_validasi_tw_4) ? $this->tx_keterangan_validasi_tw_4 : '-',
            'capaian_tw_1' => ($this->f_capaian_tw_1) ? $this->f_capaian_tw_1 : '-',
            'capaian_tw_2' => ($this->f_capaian_tw_2) ? $this->f_capaian_tw_2 : '-',
            'capaian_tw_3' => ($this->f_capaian_tw_3) ? $this->f_capaian_tw_3 : '-',
            'capaian_tw_4' => ($this->f_capaian_tw_4) ? $this->f_capaian_tw_4 : '-',
            'path_folder_1' => $path_folder_1,
            'path_folder_2' => $path_folder_2,
            'path_folder_3' => $path_folder_3,
            'path_folder_4' => $path_folder_4,
        ];

        return $data;
    }
}
