<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Diskominfotik\QueryFilter\Traits\HasQueryFilter;
use Illuminate\Database\Eloquent\Model;

class ViewJabatanTropd extends Base
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
	// protected $keyType = 'string';

	/**
	 * The primary key for the model.
	 *
	 * @var string
	 */
	protected $primaryKey = false;

	/**
	 * Create a new Eloquent model instance.
	 *
	 * @param  array  $attributes
	 * @return void
	 */
	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->setTable(config('tables.view.vw_jabatan_tropd'));
	}

}
