<?php

namespace App\Http\Resources\Input\Aktivitas;

use Illuminate\Http\Resources\Json\JsonResource;

class HolidayResources extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    $hasRanges = round((strtotime($this->end_holiday) - strtotime($this->start_holiday)) / (60 * 60 * 24)) > 0;
    return [
      'id' => $this->slug_path,
      'groupId' => 'holidays',
      'start' => date(DATE_ISO8601, strtotime($this->start_holiday)),
      'end' => $hasRanges ? $this->withEndOfday($this->end_holiday) : date(DATE_ISO8601, strtotime($this->end_holiday)),
      'title' => $this->holiday,
      'classNames' => 'holidays',
      'hasRanges' => (bool)$hasRanges,
    ];
  }

  protected function withEndOfday($strDate)
  {
    $temp = mb_strpos($strDate, ':') ? explode(' ', $strDate)[0] : $strDate;
    $format = "{$temp}T01:00:00+0700";
    return date(DATE_ISO8601, strtotime($format));
  }
}
