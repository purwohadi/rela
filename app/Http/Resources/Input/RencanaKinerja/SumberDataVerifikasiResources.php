<?php

namespace App\Http\Resources\Input\RencanaKinerja;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class SumberDataVerifikasiResources extends JsonResource
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
            'indikator' => $this->tx_indikator,
            'satuan' => $this->v_satuan
        ];

        return $data;
    }
}
