<?php

namespace App\Models;

use App\Models\Traits\HasHashSlug;
use App\Traits\HasCompositePrimaryKey;
use Diskominfotik\QueryFilter\Traits\HasQueryFilter;

class LayananProses extends Base
{
	use HasHashSlug;
	use HasCompositePrimaryKey, HasQueryFilter;
	
	public $incrementing = false;

	/**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

	/**
	 * The primary key for the model.
	 *
	 * @var string
	 */
	protected $primaryKey = 'layanan_id';
	protected $keyType = 'string';
	// protected $primaryKey = false;
	
	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

	/**
	 * Create a new Eloquent model instance.
	 *
	 * @param  array  $attributes
	 * @return void
	 */
	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->setTable(config('tables.master.layanan_proses'));
	}
}
