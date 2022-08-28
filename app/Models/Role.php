<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as BaseRole;
use Diskominfotik\QueryFilter\Traits\HasQueryFilter;

class Role extends BaseRole
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
  protected $fillable = [
    'name', 'guard_name'
  ];

  /**
   * for only dynamic seachable field
   *
   * @var array
   */
  private $searchable = ['name', 'guard_name'];

  /**
   * for only dynamic relationSeachable field
   *
   * @var array
   */
  private $relationCanSearchable = [
    'permissions|name',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
