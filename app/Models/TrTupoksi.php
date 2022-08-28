<?php

namespace App\Models;

use Diskominfotik\QueryFilter\Traits\HasQueryFilter;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasHashSlug;

class TrTupoksi extends Model
{
  use HasQueryFilter, HasHashSlug;

  public $incrementing = false;

  protected $keyType = 'string';

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->setTable(config('tables.reference.tupoksi'));
  }
}
