<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface PetaRencanaRepositoryInterface
{
    public function getInisiatif(Request $request);
    public function getProgramRoadmap(Request $request);
    public function getDataRPDbyBidur(Request $request);
    public function getRefInisiatif(Request $request);
    public function getBidurByOPD(Request $request);
    public function save(Request $request);
    public function update(Request $request);
    public function searchInisiatif(Request $request);
    public function delete(Request $request);
    public function getKegiatanTree(Request $request);
}
