<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Diskominfotik\QueryFilter\Traits\HasQueryFilter;
use Spatie\Permission\Models\Permission as BasePermisson;

class Permission extends BasePermisson
{
  use Uuids, SoftDeletes;
  // use HasQueryFilter;

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
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

  /**
   * for only dynamic seachable field
   *
   * @var array
   */
  private $searchable = ['name', 'guard_name'];

  public function menu()
  {
    return $this->hasOne(Menu::class);
  }
}
