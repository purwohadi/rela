<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Diskominfotik\QueryFilter\Traits\HasQueryFilter;
use Illuminate\Database\Eloquent\Model;

class ViewPegawai extends Base
{
  use HasCompositePrimaryKey, HasQueryFilter;

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
  protected $primaryKey = ['v_nrk', 'v_thbl'];

  /**
   * The Atasan Table.
   *
   * @var string
   */
  protected $tableAtasan;

  /**
   * Create a new Eloquent model instance.
   *
   * @param  array  $attributes
   * @return void
   */
  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->setTable(config('tables.view.pegawai'));
    $this->tableAtasan = config('tables.master.atasan_pelaksana');
  }

  /**
   * Scope a query filter by thbl
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param string $thbl
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeByThbl($query, $thbl)
  {
    return $query
      ->where('v_thbl', $thbl);
  }

  /**
   * Scope a query to only atasan
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeIsAtasan($query)
  {
    return $query
      ->where('v_eselon', '!=', '00')
      ->whereNotNull('v_eselon')
      ->whereNotNull(\DB::raw('trim(v_eselon)'));
  }

  /**
   * Scope a query fiter by spmu
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * * @param string|array $spmu
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeBySpmu($query, $spmu)
  {
    if (is_array($spmu) || mb_strpos($spmu, ',')) {
      return $query->whereIn('v_spmu', $spmu);
    }

    return $query->where('v_spmu', $spmu);
  }

  /**
   * Scope a query fiter by kolok
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * * @param string|array $kolok
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeByKolok($query, $kolok)
  {
    return $query->where('v_kolok', $kolok);
  }

  /**
   * Scope a query fiter by nrk
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * * @param string $nrk
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeByNrk($query, $nrk)
  {
    return $query
      ->where('v_nrk', $nrk);
  }

  /**
   * Get jabatan struktural associated with pegawai.
   *
   * @return Illuminate\Database\Eloquent\Concerns\HasRelationships::hasOne
   */
  public function jabatan_struktural()
  {
    return $this->hasOne(PersKojab::class, 'kojab', 'v_kojab');
  }

  /**
   * Get jabatan fungsional associated with pegawai.
   *
   * @return Illuminate\Database\Eloquent\Concerns\HasRelationships::hasOne
   */
  public function jabatan_fungsional()
  {
    return $this->hasOne(PersKojabf::class, 'kojab', 'v_kojab');
  }

  /**
   * Get bawahan associated with pegawai.
   *
   * @return Illuminate\Database\Eloquent\Concerns\HasRelationships::hasManyThrough
   */
  public function bawahanDetails()
  {
    return $this->hasManyThrough(
      ViewPegawai::class,
      ViewAtasanBawahan::class,
      'nrk_atasan',
      'v_nrk',
      'v_nrk',
      'nrk_bawahan'
    );
  }

  /**
   * Get skpd associated with pegawai.
   *
   * @return Illuminate\Database\Eloquent\Concerns\HasRelationships::hasOne
   */
  public function skpd()
  {
    return $this->hasOne(Skpd::class, 'v_kode_skpd', 'v_kolok');
  }

  /**
   * Get bawahan associated with pegawai.
   *
   * @return mixed
   */
  public function cekBawahan()
  {
    return $this->hasMany(ViewAtasanBawahan::class, 'kojab_atasan', 'v_kojab');
  }

  public function pegawaiEkp()
  {
    return $this->hasOne(ViewPegawaiEkp::class, 'v_nrk', 'v_nrk');
  }

  /**
   * Get Jabatan attribute.
   *
   * @return mixed
   */
  public function getJabatanPegawaiAttribute()
  {
    $jabatan = $this->e_kd == 'S'
      ? $this->jabatan_struktural()->where('kolok', $this->v_kolok)
      : $this->jabatan_fungsional();

    return $jabatan->first()->najabl ?? null;
  }

  /**
   * Get Nama SKPD attribute.
   *
   * @return mixed
   */
  public function getNamaSkpdAttribute()
  {
    return $this->skpd()->first()->v_nama_skpd ?? null;
  }

  /**
   * Get HasBawahan attribute.
   *
   * @return mixed
   */
  public function getHasBawahanAttribute()
  {
    return $this->cekBawahan()
      ->where('vw_atasan_bawahan.v_thbl', $this->v_thbl)
      ->where('vw_atasan_bawahan.kolok_atasan', $this->v_kolok)
      ->count() > 0;
  }

  public function getSlugPathAttribute()
  {
    $keys = [
      $this->v_thbl,
      $this->v_nrk,
      $this->v_kolok,
      $this->v_kojab,
    ];

    return encrypt_hashid(implode('|', $keys));
  }
}
