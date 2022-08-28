<?php

namespace App\Models;

use Diskominfotik\QueryFilter\Traits\HasQueryFilter;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasHashSlug;

class TmInformasiDetail extends Model
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
    $this->setTable(config('tables.master.tm_informasi_detail'));
  }

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'info_id', 'nama_data', 'rad_level_1', 'rad_level_2', 'uraian_data', 'komponen_data', 'tujuan_data', 'sifat_data', 'jenis_data1', 'jenis_data2', 'jenis_lain', 'format_struct', 'format_unstruct', 'format_lain', 'dampak_risiko', 'level_data', 'metode', 'jumlah_record', 'data_owner', 'validitas', 'interoperabilitas', 'domain_code', 'id', 'created_by', 'created_at', 'updated_by', 'deleted_by'
  ];

  public function scopeActive($query)
  {
      return $query->whereNull('tm_informasi_detail.deleted_at');
  }

  public function interoperabilitas()
  {
		return $this->belongsToMany('App\Models\TmInformasi', 'TM_INFORMASI_INTEROPERABILITAS', 'info_detail_id', 'data_id')->active();
  }
}
