<?php

namespace App\Http\Resources;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class AktivitasValidasiResources extends JsonResource
{
    /**
    * Transform the resource into an array.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function toArray($request)
    {
        $aktivitas = intval($this->aktivitas);
        $sudah_verifikasi = intval($this->sudah_verifikasi);
        $data = [
            'nrk' => $this->nrk_bawahan,
            'nama' => $this->v_nama,
            'thbl' => $this->v_thbl,
            'kode' => $this->kd_bawahan,
            'nalok' => $this->nalok,
            'najab' => $this->najab_bawahan,
            'kolok' => $this->kolok_bawahan,
            'kojab' => $this->kojab_bawahan,
            'aktivitas' => $aktivitas,
            'sudah_verifikasi' => $sudah_verifikasi,
            'belum_verifikasi' => $aktivitas - $sudah_verifikasi,
        ];

        return $data;
    }
}
