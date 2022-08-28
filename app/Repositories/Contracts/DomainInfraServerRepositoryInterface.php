<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface DomainInfraServerRepositoryInterface
{
    public function listData(Request $request);
	public function delete(Request $request);
	public function update(Request $request);
	public function save(Request $request);
    public function show(Request $request);
}
