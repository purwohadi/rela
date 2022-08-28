<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Diskominfotik\QueryFilter\Traits\HasQueryFilter;

class Reference extends Model
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
  protected $fillable = ['key', 'value', 'type'];

  /**
   * for only dynamic seachable field
   *
   * @var array
   */
  private $searchable = ['key', 'value', 'type'];

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->setTable(config('tables.reference.references'));
  }

  /**
   * Scope a query to only include reference of a given key.
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @param  mixed  $type
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeOfKey($query, $key)
  {
    return $query->where('key', $key);
  }

  /**
   * Scope a query to only include reference of a given value.
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @param  mixed  $type
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeOfValue($query, $value)
  {
    return $query->where('value', $value);
  }

  /**
   * Scope a query to only include reference of a given type.
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @param  mixed  $type
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeOfType($query, $type)
  {
    return $query->where('type', $type);
  }
}
