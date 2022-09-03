<?php

namespace App\Models;

use App\Models\Traits\HasHashSlug;
use Illuminate\Database\Eloquent\Model;
// use Diskominfotik\QueryFilter\Traits\HasQueryFilter;

class AuditTrails extends Model
{
  // use HasQueryFilter;
  use HasHashSlug;
  protected $primaryKey = "i_id";
  const CREATED_AT = 'dt_waktu_aksi';
  const UPDATED_AT = NULL;

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->setTable(config('tables.log.audit_trail'));
  }

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'v_user_aksi'
    , 'v_ip_user'
    , 'e_jenis_aksi'
    , 'v_nama_tabel'
    , 'tx_data'
  ];

  protected $casts = [
    'tx_data' => 'array'
  ];
}
