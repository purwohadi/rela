<?php

namespace App\Models;

use Diskominfotik\QueryFilter\Traits\HasQueryFilter;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasHashSlug;

class TmInfrastrukturSplp extends Model
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
    $this->setTable(config('tables.master.tm_infra_splp'));
  }

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'id',
    'rai_level_1',
    'rai_level_2',
    'rai_level_3',
    'rai_level_4',
    'nama',
    'opd_id',
    'deskripsi',
    'jenis',
    'ownership',
    'nama_owner',
    'app_dihubungkan',
    'app_terhubung',
    'domain_code',
    'created_by',
    'created_at',
    'deleted_by',
    'deleted_at',
    'updated_by',
    'updated_at'
    // 'nama_jip',
    // 'instansi',
  ];
}