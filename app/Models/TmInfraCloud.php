<?php

namespace App\Models;

use Diskominfotik\QueryFilter\Traits\HasQueryFilter;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasHashSlug;

class TmInfraCloud extends Model
{
  use HasQueryFilter, HasHashSlug;

  /**
   * The primary key for the model.
   *
   * @var string
   */
  protected $primaryKey = 'id';

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = [];

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->setTable(config('tables.master.tm_infra_cloud'));
  }

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'id',
    'nama',
    'opd_id',
    'rai_level_1',
    'rai_level_2',
    'rai_level_3',
    'deskripsi',
    'nama_owner',
    'status_ownership',
    'unit_dev',
    'unit_oper',
    'biaya',
    'jangka_waktu',
    'domain_code',
    'created_by',
    'created_at',
    'deleted_by',
    'deleted_at',
    'updated_by',
    'updated_at',
  ];
}
