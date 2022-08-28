<?php

namespace App\Models;

use App\Models\Traits\HasHashSlug;
use Illuminate\Database\Eloquent\Model;
use Diskominfotik\QueryFilter\Traits\HasQueryFilter;

class UserGroup extends Model
{
  use HasQueryFilter, HasHashSlug;
  protected $primaryKey = "i_id";
  const CREATED_AT = 'dt_created_at';

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->setTable(config('tables.master.user_group'));
  }

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'i_id'
    ,'v_userid'
    , 'v_group_id'
    , 'dt_created_at'
    , 'v_created_by'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [];

  public function group()
  {
    return $this->hasOne(Group::class, 'i_id', 'v_group_id');
  }

  public function user()
  {
    return $this->hasOne(User::class, 'v_userid', 'v_userid');
  }
}
