<?php

namespace App\Models;

use App\Models\Traits\HasHashSlug;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Builder;
// use Diskominfotik\QueryFilter\Traits\HasQueryFilter;

class ReferensiUmum extends Base
{
  // use HasQueryFilter;
  use HasHashSlug;

  /**
   * The primary key for the model.
   *
   * @var string
   */
  protected $primaryKey = 'i_id';

  /**
   * Create a new Eloquent model instance.
   *
   * @param  array  $attributes
   * @return void
   */
  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->setTable(config('tables.reference.referensi_umum'));
  }

  /**
   * The "booting" method of the model.
   *
   * @return void
   */
  protected static function boot()
  {
    parent::boot();
    $self = (new self);
    static::addGlobalScope('active', function (Builder $builder) use ($self) {
      $self->scopeIsActive($builder);
    });
  }

  /**
   * Scope a query to only active referensi_umum.
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeIsActive($query)
  {
    return $query->where('e_aktif', 1);
  }

  /**
   * Scope a query to only not active referensi_umum.
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeIsNotActive($query)
  {
    return $query->where('e_aktif', 0);
  }

  /**
   * Scope a query to remove active filter referensi_umum.
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeIsActiveOrNotActive($query)
  {
    return $query->withoutGlobalScope('active');
  }

  /**
   * Scope a query to get specific type of referensi_umum.
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @param  string  $type
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeWhereType($query, $type)
  {
    return $query->where('v_type', $type);
  }
}
