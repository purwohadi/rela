<?php

namespace App\Http\Resources;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class InboxListResources extends JsonResource
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
      'i_id' => $this->i_id,
      'v_sent_by' => $this->v_sent_by,
      'd_sent_date' => $this->d_sent_date,
      'd_sent_date_convert' => GeneralHelper::dateTimeIndoConverter($this->d_sent_date),
      'tx_isi_pesan' => $this->tx_isi_pesan,
      'e_status_pesan' => $this->e_status_pesan,
      'v_id_penerima' => $this->v_id_penerima,
      'e_type_penerima' => $this->e_type_penerima,
    ];

    $group = $this->e_type_penerima == 'group' ? $this->group : null;
    $pengirim = $this->pengirim;
    $penerima = $this->penerima;
    $data['group'] = $group ? new GroupResources($group) : null;
    $data['pengirim'] = $pengirim ? [
      'v_userid' => $pengirim->v_userid,
      'v_username' => $pengirim->v_username,
      'current_eselon' => $pengirim->current_eselon,
      'email' => $pengirim->email,
      'slug_path' => $pengirim->slug_path,
      'media' => $pengirim->media,
    ] : null;
    $data['penerima'] = $penerima ? [
      'v_userid' => $penerima->v_userid,
      'v_username' => $penerima->v_username,
      'current_eselon' => $penerima->current_eselon,
      'email' => $penerima->email,
      'slug_path' => $penerima->slug_path,
      'media' => $penerima->media,
    ] : null;

    return $data;
  }
}
