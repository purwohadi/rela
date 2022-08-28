<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface DomainInfraSplpRepositoryInterface
{
	/**
	 * Get's domain infra splp by specific condition.
	 *
	 * @return mixed
	 */
	public function getDataBy(Request $request);
}
