<?php

namespace App\Models;

// use Diskominfotik\QueryFilter\Traits\HasQueryFilter;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasHashSlug;

class Group extends Model
{
  // use HasQueryFilter;
  use HasHashSlug;
  protected $primaryKey = "i_id";
  const CREATED_AT = 'dt_created_at';
  const UPDATED_AT = 'dt_updated_at';

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->setTable(config('tables.master.group'));
  }

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'v_group_name'
    ,'v_opd_id'
    , 'e_status_aktif'
    , 'v_created_by'
    , 'v_updated_by'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ['dt_created_at', 'dt_updated_at'];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'e_status_aktif' => 'integer',
  ];

  /**
   * for only dynamic seachable field
   *
   * @var array
   */
  private $searchable = ['v_group_name', 'e_status_aktif', 'v_opd_id'];

  /**
   * for only dynamic relationSeachable field
   *
   * @var array
   */
  private $relationCanSearchable = [
    'features|v_name',
  ];

  public function featureGroup()
  {
    return $this->hasMany(FeatureAccessGroup::class, 'i_group_id', 'i_id');
  }

  public function opd()
  {
    return $this->hasOne(Opd::class, 'opd_id', 'v_opd_id');
  }

  /**
   * Get all of the feature for the group.
   */
  public function features()
  {
    $pivot = config('tables.master.feature_access_group');
    return $this->belongsToMany(
      FeatureAccess::class,
      $pivot,
      'i_group_id',
      'i_feature_id',
      'i_id',
      'i_id'
    );
  }
}
