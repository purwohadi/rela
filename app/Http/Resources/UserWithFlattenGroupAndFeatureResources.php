<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserWithFlattenGroupAndFeatureResources extends JsonResource
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
      'is_active' => $this->is_active,
      'is_admin' => $this->is_admin,
      'is_admin_skpd' => $this->is_admin_skpd,
      'is_admin_ukpd' => $this->is_admin_ukpd,
      'is_common_user' => $this->is_common_user,
      'last_update_password' => $this->d_last_update_pass,
      'roles' => null,
      'permissions' => null,
    ];

    $mergeFeatures = [];
    if ($groups = $this->groups->load('features')) {
      $data['roles'] = $groups->pluck('v_group_name');
      $features = $groups->map(function($group) {
        return $group->features->pluck('v_alias');
      });
      $mergeFeatures = array_merge($mergeFeatures, $features->toArray());
    }

    if (count($mergeFeatures) > 0) {
      $data['permissions'] = collect($mergeFeatures)->flatten();
    }

    // $onlyMenu = $this->groups->load(['features' => function ($query) { $query->isMenu(); }]);
    // dd($onlyMenu->toArray());

    return $data;
  }
}
