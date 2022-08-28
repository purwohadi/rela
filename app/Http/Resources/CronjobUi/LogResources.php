<?php

namespace App\Http\Resources\CronjobUi;

use Illuminate\Http\Resources\Json\JsonResource;

class LogResources extends JsonResource
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
      'slug_path' => $this->slug_path,
      'command' => $this->command,
      // 'payload' => $this->payload,
      'status' => $this->status,
      'reason' => $this->reason,
      'action_by' => $this->action_by,
      'started_at' => $this->started_at,
      'finished_at' => $this->finished_at,
    ];

    return $data;
  }
}
