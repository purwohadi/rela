<?php

namespace App\Models;

use Diskominfotik\QueryFilter\Traits\HasQueryFilter;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasHashSlug;

class DomainInfrastrukturCloud extends Model
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
    $this->setTable(config('tables.master.domain_infra_cloud'));
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
    'opd_id',
    'instansi',
    'nama',
    'deskripsi',
    'tipe',
    'status_ownership',
    'nama_owner',
    'biaya',
    'unit_dev',
    'unit_oper',
    'kode_l01',
    'kode_l02',
    'kode_l03',
    'kode_l04',
    'domain_code',
    'id_metadata_terkait',
    'jangka_waktu',
    'created_by',
    'updated_by'
  ];
}
