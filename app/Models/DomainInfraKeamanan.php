<?php

namespace App\Models;

//use Diskominfotik\QueryFilter\Traits\HasQueryFilter;
//use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasHashSlug;

class DomainInfraKeamanan extends Base
{
	use HasHashSlug;
	
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
	protected $primaryKey = 'id';
	
	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

	/**
	 * Create a new Eloquent model instance.
	 *
	 * @param  array  $attributes
	 * @return void
	 */

	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->setTable(config('tables.master.domain_infra_keamanan'));
	}
}