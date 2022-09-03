<?php

namespace App\Models;

use App\Models\Traits\HasHashSlug;
use Illuminate\Database\Eloquent\Model;
// use Diskominfotik\QueryFilter\Traits\HasQueryFilter;

class FeatureAccess extends Model
{
  // use HasQueryFilter;
  use HasHashSlug;
  protected $primaryKey = "i_id";
  const CREATED_AT = 'dt_created_at';
  const UPDATED_AT = 'dt_updated_at';

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->setTable(config('tables.master.feature_access'));
  }

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'v_name'
    , 'v_alias'
    , 'e_type'
    , 'i_parentid'
    , 'v_route'
    , 'v_params'
    , 'v_icon'
    , 'i_order_no'
    , 'v_description'
    , 'v_created_by'
    , 'v_updated_by'
  ];

  /**
   * for only dynamic seachable field
   *
   * @var array
   */
  private $searchable = ['v_name', 'v_alias', 'e_type'];

  /**
   * Scope a query to only include menu of a given parent.
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeIsParent($query)
  {
    return $query->whereNull('i_parentid');
  }

  /**
   * Scope a query to only include menu of a given child.
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeIsChild($query)
  {
    return $query->whereNotNull('i_parentid');
  }

  public function scopeIsMenu($query)
  {
    return $query->where('e_type', 'menu');
  }

  // parent relation
  public function parent() {
    return $this->belongsTo(FeatureAccess::class , 'i_parentid');
  }
  //child relation
  public function children() {
    return $this->hasMany(FeatureAccess::class ,'i_parentid')->with('parent');
  }

  /**
   * Get the children that owns menu.
   */
  // public function children()
  // {
  //   return $this->hasMany(FeatureAccess::class, 'i_parentid', 'id');
  //   // return $this->hasMany(FeatureAccess::class, 'id', 'i_parentid');
  // }
}
