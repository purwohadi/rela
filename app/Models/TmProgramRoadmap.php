<?php

namespace App\Models;

use App\Models\Traits\HasHashSlug;

class TmProgramRoadmap extends Base
{
	use HasHashSlug;

    public $timestamps = false;

	protected $primaryKey = 'id';

	protected $guarded = [];

	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->setTable(config('tables.master.tm_program_roadmap'));
	}
}
