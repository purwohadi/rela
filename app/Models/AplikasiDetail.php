<?php

namespace App\Models;

use App\Models\Traits\HasHashSlug;
use \Illuminate\Database\Eloquent\Builder;

class AplikasiDetail extends Base
{
  use HasHashSlug;

  public $incrementing = false;
	protected $primaryKey = 'id';

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = [];

  /**
   * Create a new Eloquent model instance.
   *
   * @param  array  $attributes
   * @return void
   */
  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->setTable(config('tables.master.aplikasi_detail'));
  }

  public function scopeActive($query)
  {
      return $query->whereNull('tm_aplikasi_detail.deleted_at');
  }
}
