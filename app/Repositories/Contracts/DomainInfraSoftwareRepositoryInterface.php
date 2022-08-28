<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface DomainInfraSoftwareRepositoryInterface
{
    public function listData(Request $request);
	public function delete(Request $request, $id);
	public function update(Request $request, $id);
	public function save(Request $request);
    public function show(Request $request);
    public function getDataBy(Request $request);
    public function getDataMetadataKeamanan(Request $request);
    public function getDataMetadataSplp(Request $request);
    public function getUsedSoftware(Request $request);
}
