<?php

namespace App\Models;

use App\Models\Traits\HasHashSlug;
use \Illuminate\Database\Eloquent\Builder;

class ViewAplikasi extends Base
{
  use HasHashSlug;

  /**
   * The primary key for the model.
   *
   * @var string
   */
	protected $primaryKey = 'apl_id';
	protected $keyType = 'string';
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
    $this->setTable(config('tables.view.vw_aplikasi'));
  }
}
