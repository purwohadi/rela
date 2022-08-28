<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class ModelHasRoles extends MorphPivot
{
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

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->setTable(config('Permission.table_names.model_has_roles'));
  }
}
