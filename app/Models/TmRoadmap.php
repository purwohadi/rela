<?php

namespace App\Models;

use App\Models\Traits\HasHashSlug;

class TmRoadmap extends Base
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
	 * Create a new Eloquent model instance.
	 *
	 * @param  array  $attributes
	 * @return void
	 */
	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->setTable(config('tables.master.tm_roadmap'));
	}

	public function scopeActive($query)
    {
        return $query->whereNull('tm_roadmap.deleted_at');
    }
}
