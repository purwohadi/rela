<?php

namespace App\Http\Resources\Input\RencanaKinerja;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class CapaianPenilaianResources extends JsonResource
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
      'v_thbl' => $this->v_thbl,
      'v_ptk_id' => $this->v_ptk_id,
      'v_nama' => $this->v_nama,
      'v_jabatan' => $this->v_jabatan,
      'v_unit_kerja' => $this->v_unit_kerja,
      'v_jabatan_ptk_id' => $this->v_jabatan_ptk_id,
      'f_var_1' => $this->f_var_1,
      'f_var_2' => $this->f_var_2,
      'f_var_3' => $this->f_var_3,
      'f_var_4' => $this->f_var_4,
      'f_var_5' => $this->f_var_5,
      'f_var_6' => $this->f_var_6,
      'f_var_7' => $this->f_var_7,
      'f_var_8' => $this->f_var_8,
      'f_total' => $this->f_total,
    ];

    $jabatanEkp = $this->jabatanEkp;
    $data['jabatan_ekp'] = $jabatanEkp ? [
      'slug_path' => $jabatanEkp->slug_path,
      'v_kode_jabatan' => $jabatanEkp->v_kode_jabatan,
      'v_nama_jabatan' => $jabatanEkp->v_nama_jabatan,
      'si_fixed' => $jabatanEkp->si_fixed,
      'si_variabel' => $jabatanEkp->si_variabel,
      'variabel' => !$jabatanEkp->ekpVariabel->isEmpty() ? $jabatanEkp->ekpVariabel->map(function ($item) {
        $nilai_variabel = null;

        for ($idx = 1; $idx < 9; $idx++) {
          if ($item->v_urutan == 'var'.$idx) {
            $nilai_variabel = $this->{'f_var_'.$idx};
          }

          $hitung_nilai = ($nilai_variabel / $item->si_bobot) * 100 ;
          $capaian_nilai = $item->capaianNilai()->where('f_nilai', $hitung_nilai)->first();
        }

        return [
          'slug_path' => $item->slug_path,
          'v_kode_va' => $item->v_kode_va,
          'v_kode_jabatan' => $item->v_kode_jabatan,
          'v_nama_variabel' => $item->v_nama_variabel,
          'si_bobot' => $item->si_bobot,
          'v_urutan' => $item->v_urutan,
          'v_kode_variabel_ekp' => $item->v_kode_variabel_ekp,
          'v_status_aktif' => $item->v_status_aktif,
          'capaian_nilai' => $capaian_nilai ? [
            'slug_path' => $capaian_nilai->slug_path,
            'v_kode_subvariabel' => $capaian_nilai->v_kode_subvariabel,
            'v_deskripsi' => $capaian_nilai->v_deskripsi,
            'f_nilai' => $capaian_nilai->f_nilai,
            'nilai_variabel' => $nilai_variabel,
          ] : []
        ];

      }) : []

    ] : [];

    return $data;
  }
}
