<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Diskominfotik\QueryFilter\Traits\HasQueryFilter;

class Menu extends Model
{
  use Uuids, SoftDeletes, HasQueryFilter;

  /**
   * Indicates if the IDs are auto-incrementing.
   *
   * @var bool
   */
  public $incrementing = false;

  /**
   * The "type" of the primary key ID.
   *
   * @var string
   */
  protected $keyType = 'string';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [ 'group'
                        , 'label'
                        , 'icon'
                        , 'tags'
                        , 'route'
                        , 'parent'
                        , 'permission_id'
                        , 'order_no'
                        , 'visible'
                        ];

  /**
   * The attributes that should be cast.
   *
   * @var array
   */
  protected $casts = [ 'visible' => 'boolean' ];

  /**
   * The accessors to append to the model's array form.
   *
   * @var array
   */
  protected $appends = ['key'];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->setTable(config('tables.master.menu'));
  }

  /**
   * Scope a query to ordered menu.
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @param  mixed  $direction
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeIsOrdered($query, $direction = 'asc')
  {
    return $query->orderBy('order_no', $direction)
      ->orderBy('label', $direction);
  }

  /**
   * Scope a query to only include menu of a given parent.
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeIsParent($query)
  {
    return $query->whereNull('parent');
  }

  /**
   * Scope a query to only include menu of a given child.
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeIsChild($query)
  {
    return $query->whereNotNull('parent');
  }

  /**
   * Scope a query to only include menu is visible.
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeIsVisible($query)
  {
    return $query->where('visible', 1);
  }

  /**
   * Scope a query to only include menu is not visible.
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeIsNotVisible($query)
  {
    return $query->where('visible', 0);
  }

  /**
   * Scope a query to show menu is in permission.
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @param  Array  $permision_id
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeIsPermissions($query, $permission_id)
  {
    return $query->whereIn('permission_id', $permission_id);
  }

  /**
   * Get the parent that owns the menu.
   */
  public function parent()
  {
    return $this->hasOne(Menu::class, 'id', 'parent');
  }

  /**
   * Get the child that owns the menu.
   */
  public function child()
  {
    return $this->hasMany(Menu::class, 'parent', 'id')
      ->orderBy('order_no', 'asc')
      ->orderBy('label', 'asc');
  }

  /**
   * Get the permision that owns menu.
   */
  public function permission()
  {
    return $this->belongsTo(Permission::class);
  }

  public function getKeyAttribute()
  {
    $key = ! is_null($this->parent)
      ? substr(str_replace('-', '', $this->parent), 16) . '.' . substr(str_replace('-', '', $this->id), 16)
      : substr(str_replace('-', '', $this->id), 16);

    return $key;
  }
}
