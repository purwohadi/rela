<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Repositories\Contracts\DomainInfraSplpRepositoryInterface;

class SplpController extends Controller
{
	protected $domainInfraSplpRepositoryInterface;

	/**
	 * FasilitasController constructor.
	 *
	 * @param DomainInfraSplpRepositoryInterface $permission
	 */
	public function __construct (DomainInfraSplpRepositoryInterface $domainInfraSplpRepositoryInterface) {
		$this->domainInfraSplpRepositoryInterface			= $domainInfraSplpRepositoryInterface;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getDataBy(Request $request)
	{
		return $this->domainInfraSplpRepositoryInterface->getDataBy($request);
	}
}
