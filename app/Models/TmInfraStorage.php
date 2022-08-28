<?php

namespace App\Models;

use Diskominfotik\QueryFilter\Traits\HasQueryFilter;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasHashSlug;

class TmInfraStorage extends Model
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
    $this->setTable(config('tables.master.tm_infra_storage'));
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
    'rai_level_4',
    'deskripsi',
    'nama_owner',
    'ownership',
    'unit_pengelola',
    'lokasi',
    'software_used',
    'kapasitas_penyimpanan',
    'data_used',
    'metode_akses_data',
    'domain_code',
    'created_by',
    'created_at',
    'deleted_by',
    'updated_by'
  ];
}
