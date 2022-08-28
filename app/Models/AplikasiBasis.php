<?php

namespace App\Models;


class AplikasiBasis extends Base
{
  public $incrementing = false;
  public $timestamps = false;

/**
 * The primary key for the model.
 *
 * @var string
 */
protected $primaryKey = 'id_apl_luaran';
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
    $this->setTable(config('tables.master.aplikasi_basis'));
  }
}
