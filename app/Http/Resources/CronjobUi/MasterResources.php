<?php

namespace App\Http\Resources\CronjobUi;

use Illuminate\Http\Resources\Json\JsonResource;

class MasterResources extends JsonResource
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
      'title' => $this->title,
      'command' => $this->command,
      'description' => $this->description,
      'schedule' => $this->schedule,
      'url' => $this->url,
      'has_processing' => $this->hasProcessing,
    ];

    if ($request->has('withLogDetails')) {
      if ($this->logDetails) {
        $data['logs'] = LogResources::collection($this->logDetails);
      }
    }

    return $data;
  }
}
