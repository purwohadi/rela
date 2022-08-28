<?php

namespace App\Http\Resources;

use App\Models\ViewPegawai;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class RenkinPppkListResources extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    $thbl = $this->v_thbl ? $this->v_thbl : $this->v_tahun.sprintf("%02d", $this->si_bulan_awal);
    $data = [
      'id' => $this->i_id,
      'id_skp' => $this->v_id_skp,
      'tahun' => $this->v_tahun,
      'status_aktif' => $this->e_status_aktif,
      'si_bulan_awal' => $this->si_bulan_awal,
      'si_bulan_akhir' => $this->si_bulan_akhir,
      'kd' => $this->c_kd,
      'nrk' => $this->v_nrk,
      'jabatan' => $this->v_jabatan,
      'unit_kerja' => $this->v_unit_kerja,
      'status_proses' => $this->e_status_proses,
      'status_tutup_periode' => $this->e_status_tutup_periode,
      'thbl' => $thbl,
      'slug_path' => $this->slug_path
    ];
    $currentPegawai = DB::table(config('tables.view.pegawai'))
    ->where('v_nrk', $this->v_nrk)
    ->where('v_thbl', $thbl)->first();
    $data['nama'] = $currentPegawai ? $currentPegawai->v_nama : null;

    $atasan = DB::table(config('tables.view.atasan_bawahan'))
    ->where('nrk_bawahan', $this->v_nrk)
    ->where('v_thbl', $thbl)->first();
    if($atasan){
      $pegawai = DB::table(config('tables.view.pegawai'))
      ->where('v_nrk', $atasan->nrk_atasan)
      ->where('v_thbl', $thbl)->first();
    }
    $data['has_atasan'] = $atasan ? true : false;
    $data['atasan'] = $atasan ? [
      'nrk' => $this->nrk_atasan,
      'nama' => $pegawai->v_nama,
      'unit_kerja' => $pegawai->nalok,
      'jabatan' => $pegawai->najabl,
    ] : [];

    return $data;
  }
}
