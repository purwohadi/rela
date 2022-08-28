<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Diskominfotik\QueryFilter\Traits\HasQueryFilter;
use App\Models\Traits\HasHashSlug;
use Illuminate\Database\Eloquent\Model;

class ViewInfraPheri extends Model
{
	use HasCompositePrimaryKey, HasQueryFilter;
	use HasHashSlug;

	/**
	 * Indicates if the IDs are auto-incrementing.
	 *
	 * @var bool
	 */
	public $incrementing = false;

	/**
	 * The primary key for the model.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id';

	/**
	 * Create a new Eloquent model instance.
	 *
	 * @param  array  $attributes
	 * @return void
	 */
	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->setTable(config('tables.view.vw_infra_pheri'));
	}
}
