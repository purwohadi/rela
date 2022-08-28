<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CheckJadwalBukaTutupResources extends JsonResource
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
      'nama_jadwal' => $this->v_jenis_jadwal,
      'tipe_jadwal' => $this->e_type_periode,
      'umum' => [],
      'khusus' => []
    ];

    if (count($this->jadwal)) {
      $umum = [];
      $khusus = [];
      $this->jadwal->each(function($item) use (&$umum, &$khusus) {
        $temp = [
          'tahun_dibuka' => $item->v_tahun_dibuka,
          'tw_bulan_dibuka' => $item->si_tw_bulan_dibuka,
          'tanggal_mulai' => $item->d_tanggal_mulai,
          'tanggal_akhir' => $item->d_tanggal_akhir,
        ];

        if (mb_strpos($item->e_dibuka_untuk, 'umum') !== false) {
          array_push($umum, $temp);
        } else {
          $temp['jenis_list'] = $item->detailKhusus->e_jenis_list;
          $temp['list_khusus'] = explode(',', $item->detailKhusus->tx_list_khusus);
          array_push($khusus, $temp);
        }
      });

      if (count($umum) > 0) {
        $data['umum'] = $umum;
      }

      if (count($khusus) > 0) {
        $data['khusus'] = $this->mergingListIfSimiliar($khusus);
      }
    }

    return $data;
  }

  /**
   * Grouping list based on tahun_dibuka, tw_bulan_dibuka, tanggal_mulai, tanggal_akhir, jenis_list
   *
   * @param array $items
   * @return array
   */
  protected function mergingListIfSimiliar(array $items)
  {
    $merging = [];
    foreach ($items as $item) {
      if (count($merging) == 0) {
        $merging[] = $item;
      } else {
        $filtered = array_filter($merging, function($temp) use ($item) {
          return $temp['tahun_dibuka'] == $item['tahun_dibuka']
            && $temp['tw_bulan_dibuka'] == $item['tw_bulan_dibuka']
            && $temp['tanggal_mulai'] == $item['tanggal_mulai']
            && $temp['tanggal_akhir'] == $item['tanggal_akhir']
            && $temp['jenis_list'] == $item['jenis_list'];
        });

        if (count($filtered) !== 0) {
          $x = [];
          foreach ($item['list_khusus'] as $y) {
            if (!in_array($y, $x)) array_push($x, $y);
          }

          foreach ($filtered as $idx => $value) {
            foreach ($merging[$idx]['list_khusus'] as $y) {
              if (!in_array($y, $x)) array_push($x, $y);
            }

            $merging[$idx]['list_khusus'] = $x;
          }
        } else {
          $merging[] = $item;
        }
      }
    }

    return $merging;
  }
}
