<?php

namespace App\Http\Resources;

use App\Http\Resources\GroupResources;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResources extends JsonResource
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
      'user_id' => $this->v_userid,
      'username' => $this->v_username,
      'userstatus' => $this->e_user_enable,
      'last_update_password' => $this->d_last_update_pass,
    ];
    $data['user_group'] = !$this->userGroup->isEmpty() ? $this->userGroup->map(function ($item) {
      $result = $item->group ? new GroupResources($item->group) : [];
      return $result;
    }) : [];

    return $data;
  }
}
