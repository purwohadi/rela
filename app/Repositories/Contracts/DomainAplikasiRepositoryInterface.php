<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface DomainAplikasiRepositoryInterface
{
	public function getDataBy(Request $request);
	public function listData(Request $request);
	public function delete(Request $request);
	public function update(Request $request);
	public function save(Request $request);
	public function getDataAplikasi(Request $request);
	public function getAplikasiDetail(Request $request);
	public function show($id);
}
