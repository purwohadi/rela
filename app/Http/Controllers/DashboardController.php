<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\DashboardRepositoryInterface;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
	protected $dashboard;

	/**
	 * PengumumanController constructor.
	 *
	 * @param DashboardRepositoryInterface $role
	 */
	public function __construct(DashboardRepositoryInterface $dashboard)
	{
		$this->dashboard = $dashboard;
	}

	/**
	 * Display a listing of the dpt
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function getDpt(Request $request)
	{
		return $this->dashboard->getDpt($request);
	}
}
