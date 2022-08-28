<?php

namespace App\Http\Resources\Roadmap;

use Illuminate\Http\Resources\Json\JsonResource;

class InisiatifResources extends JsonResource
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
      'slug_path' => $this->slug_path,
      'nama_inisiatif' => $this->nama_inisiatif,
      'kegiatan' => $this->kegiatan,
      'sub_kegiatan' => $this->sub_kegiatan,
      'kegiatan_teks' => $this->kegiatan.'-'.$this->nama_kegiatan,
      'sub_kegiatan_teks' => $this->sub_kegiatan.'-'.$this->nama_sub_kegiatan,
      'unit_pj' => $this->unit_pj,
      'tahun_implementasi' => $this->tahun_implementasi,
      'domain' => $this->domain_arsitektur,
      'program' => $this->program,
      'program_id' => $this->program_id,
      'opd_id' => $this->opd_id
    ];

    return $data;
  }
}
