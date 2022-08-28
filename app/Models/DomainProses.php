<?php

namespace App\Models;

use Diskominfotik\QueryFilter\Traits\HasQueryFilter;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasHashSlug;

class DomainProses extends Model
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
		$this->setTable(config('tables.master.domain_proses'));
	}

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'proses_id'
    , 'opd_id'
    , 'nama_opd'
    , 'rab_level1'
    , 'rab_level2'
    , 'rab_level3'
    , 'rab_level4'
    , 'kode_l01'
    , 'kode_l02'
    , 'kode_l03'
    , 'kode_l04'
    , 'domain_code'
    , 'tupoksi'
    , 'created_by'
    , 'updated_by'
    , 'deleted_by'
  ];
}
