<?php
use App\Http\Controllers\PetaRencanaController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'peta-rencana', 'as' => 'peta-rencana.'], function ()
{
	Route::get('bid-urusan', [PetaRencanaController::class, 'getBidUrusan'])->name('get-bidur');
	Route::get('ref-inisiatif', [PetaRencanaController::class, 'getRefInisiatif'])->name('get-ref-inisiatif');
	Route::get('kegiatan-tree', [PetaRencanaController::class, 'getKegiatanTree'])->name('get-kegiatan-tree');
	Route::get('data-rpd', [PetaRencanaController::class, 'getDataRPD'])->name('get-data-rpd');
	Route::get('bidur-opd', [PetaRencanaController::class, 'getBidurByOPD'])->name('bidur-opd');
	Route::post('update', [PetaRencanaController::class, 'update'])->name('update');
	Route::post('save', [PetaRencanaController::class, 'save'])->name('save'); 
	Route::get('inisiatif', [PetaRencanaController::class, 'searchInisiatif'])->name('search-inisiatif');
	Route::post('delete', [PetaRencanaController::class, 'delete'])->name('delete');
});
