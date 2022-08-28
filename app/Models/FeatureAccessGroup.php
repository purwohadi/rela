<?php

namespace App\Models;

use App\Models\Traits\HasHashSlug;
use Illuminate\Database\Eloquent\Model;
use Diskominfotik\QueryFilter\Traits\HasQueryFilter;

class FeatureAccessGroup extends Model
{
  use HasQueryFilter, HasHashSlug;
  protected $primaryKey = "i_id";
  const CREATED_AT = 'dt_created_at';
  const UPDATED_AT = NULL;

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->setTable(config('tables.master.feature_access_group'));
  }

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'i_group_id'
    , 'i_feature_id'
    , 'v_created_by'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'dt_created_at'
    , 'dt_updated_at'
  ];

  public function featureAccess()
  {
    return $this->hasOne(FeatureAccess::class, 'i_id', 'i_feature_id');
  }
}
