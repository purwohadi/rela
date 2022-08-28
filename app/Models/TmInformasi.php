<?php

namespace App\Models;

use Diskominfotik\QueryFilter\Traits\HasQueryFilter;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasHashSlug;

class TmInformasi extends Model
{
	use HasQueryFilter, HasHashSlug;

	/**
	 * The primary key for the model.
	 *
	 * @var string
	 */
	protected $primaryKey = 'info_id';

  /**
   * Indicates if the IDs are auto-incrementing.
   *
   * @var bool
   */
  public $incrementing = false;

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = [];

	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->setTable(config('tables.master.tm_informasi'));
	}

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'info_id'
    , 'nama_data'
    , 'nama_opd'
    , 'rad_level_1'
    , 'rad_level_2'
    , 'rad_level_3'
    , 'opd_id'
    , 'created_by'
    , 'created_at'
    , 'updated_by'
    , 'updated_at'
    , 'deleted_by'
    , 'deleted_at'
  ];

  public function scopeActive($query)
  {
      return $query->whereNull('tm_informasi.deleted_at');
  }

  public function opd()
	{
		return $this->hasOne('App\Models\Opd', 'opd_id', 'opd_id');
	}
}
