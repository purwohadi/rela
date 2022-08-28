<?php

namespace App\Models;

use App\Models\Traits\{HasHashSlug, HasUserAttribute, HasUserMediaAttribute};
use App\Traits\HasCompositePrimaryKey;
use Diskominfotik\QueryFilter\Traits\HasQueryFilter;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skpd extends Base
{
  use HasCompositePrimaryKey, HasQueryFilter, HasHashSlug;

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

  /**
   * The primary key for the model.
   *
   * @var string
   */
  protected $primaryKey = 'v_kode_skpd';

  protected $guarded = [];

  protected $tableAtasan;

  protected $casts = [
    'e_is_induk' => 'boolean',
  ];

  /**
   * The accessors to append to the model's array form.
   *
   * @var array
   */
  protected $appends = ['is_induk', 'bidang'];

  /**
   * Create a new Eloquent model instance.
   *
   * @param  array  $attributes
   * @return void
   */
  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->setTable(config('tables.reference.skpd'));
  }

  /**
   * Get the kodeSpm associated with the skpd.
   *
   * @return void
   */
  public function kodeSpm()
  {
    return $this->hasOne(PersKlogad::class, 'kolok', 'v_kode_skpd');
  }

  /**
   * Get the induk reference.
   *
   * @return mixed
   */
  public function refInduk()
  {
    return $this
      ->hasOne(ReferensiUmum::class, 'v_key', 'e_is_induk')
      ->whereType('Ref Induk PD');
  }

  /**
   * Get the bidang reference.
   *
   * @return mixed
   */
  public function refBidang()
  {
    return $this
      ->hasOne(ReferensiUmum::class, 'v_key', 'e_bidang')
      ->whereType('Ref Bidang PD');
  }

  /**
   * Get the tipe induk skpd.
   *
   * @return mixed
   */
  public function getIsIndukAttribute()
  {
    return $this->refInduk()->first()->v_value ?? null;
  }

  /**
   * Get the bidang skpd.
   *
   * @return mixed
   */
  public function getBidangAttribute()
  {
    return $this->refBidang()->first()->v_value ?? null;
  }
}
