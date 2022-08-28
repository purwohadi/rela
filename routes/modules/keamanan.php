<?php
use App\Http\Controllers\DomainAplikasiController;
use App\Http\Controllers\StandarTeknisKeamananController;
use App\Http\Controllers\DomainEdukasiKeamananController;
use App\Http\Controllers\DomainAuditKeamananController;
use App\Http\Controllers\DomainPeningkatanKeamananController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'standar-teknis-keamanan', 'as' => 'standar-teknis-keamanan.'], function ()
{
	Route::get('data-standar-teknis-keamanan', [StandarTeknisKeamananController::class, 'dataStandarKeamanan'])->name('data-standar-teknis-keamanan.get');
	Route::post('/simpan-data-domain-standar-keamanan', [StandarTeknisKeamananController::class, 'simpanDataDomainStandarKeamanan'])->name('simpan-data-domain-standar-keamanan');  
	Route::post('/update-data-domain-standar-keamanan', [StandarTeknisKeamananController::class, 'updateDataDomainStandarKeamanan'])->name('update-data-domain-standar-keamanan');
	Route::post('/delete-data-domain-standar-keamanan', [StandarTeknisKeamananController::class, 'deleteDataDomainStandarKeamanan'])->name('delete-data-domain-standar-keamanan');
  	Route::get('/search-standar-keamanan', [StandarTeknisKeamananController::class, 'searchStandarKeamanan'])->name('search-standar-keamanan.get');
	Route::get('metadata', [StandarTeknisKeamananController::class, 'getMetadata'])->name('get-metadata');
	Route::get('nama-aplikasi', [StandarTeknisKeamananController::class, 'searchNamaAplikasi'])->name('get-nama-aplikasi');
});

Route::group(['prefix' => 'aplikasi', 'as' => 'aplikasi.'], function ()
{
	Route::get('get-data-by', [DomainAplikasiController::class, 'getDataBy'])->name('get-data-by.get');
});


/* Edukasi Keamanan */
Route::group(['prefix' => 'edukasi', 'as' => 'edukasi.'], function ()
{
	Route::get('data-edukasi-keamanan', [DomainEdukasiKeamananController::class, 'dataEdukasiKeamanan'])->name('data-edukasi-keamanan.get');  
	Route::post('/simpan-data-edukasi-keamanan', [DomainEdukasiKeamananController::class, 'simpanDataDomainEdukasiKeamanan'])->name('simpan-data-domain-edukasi-keamanan');  
	Route::post('/update-data-edukasi-keamanan', [DomainEdukasiKeamananController::class, 'updateDataDomainEdukasiKeamanan'])->name('update-data-domain-edukasi-keamanan');
	Route::post('/delete-data-edukasi-keamanan', [DomainEdukasiKeamananController::class, 'deleteDataDomainEdukasiKeamanan'])->name('delete-data-domain-edukasi-keamanan');
    Route::get('/search-edukasi-keamanan', [DomainEdukasiKeamananController::class, 'searchDomainEdukasiKeamanan'])->name('search-edukasi-keamanan.get');
	Route::get('metadata', [DomainEdukasiKeamananController::class, 'getMetadata'])->name('get-metadata');
});


/* Audit Keamanan */
Route::group(['prefix' => 'audit', 'as' => 'audit.'], function ()
{
	Route::get('data-audit-keamanan', [DomainAuditKeamananController::class, 'dataAuditKeamanan'])->name('data-audit-keamanan.get');  
	Route::post('/simpan-data-audit-keamanan', [DomainAuditKeamananController::class, 'simpanDataDomainAuditKeamanan'])->name('simpan-data-domain-audit-keamanan');  
	Route::post('/update-data-audit-keamanan', [DomainAuditKeamananController::class, 'updateDataDomainAuditKeamanan'])->name('update-data-domain-audit-keamanan');
	Route::post('/delete-data-audit-keamanan', [DomainAuditKeamananController::class, 'deleteDataDomainAuditKeamanan'])->name('delete-data-domain-audit-keamanan');
    Route::get('/search-audit-keamanan', [DomainAuditKeamananController::class, 'searchDomainAuditKeamanan'])->name('search-audit-keamanan.get');
	Route::get('metadata', [DomainAuditKeamananController::class, 'getMetadata'])->name('get-metadata');
});


/* Peningkatan Keamanan */
Route::group(['prefix' => 'peningkatan', 'as' => 'peningkatan.'], function ()
{
	Route::get('data-peningkatan-keamanan', [DomainPeningkatanKeamananController::class, 'dataPeningkatanKeamanan'])->name('data-peningkatan-keamanan.get');  
	Route::post('/simpan-data-peningkatan-keamanan', [DomainPeningkatanKeamananController::class, 'simpanDataDomainPeningkatanKeamanan'])->name('simpan-data-domain-peningkatan-keamanan');  
	Route::post('/update-data-peningkatan-keamanan', [DomainPeningkatanKeamananController::class, 'updateDataDomainPeningkatanKeamanan'])->name('update-data-domain-peningkatan-keamanan');
	Route::post('/delete-data-peningkatan-keamanan', [DomainPeningkatanKeamananController::class, 'deleteDataDomainPeningkatanKeamanan'])->name('delete-data-domain-peningkatan-keamanan');
    Route::get('/search-peningkatan-keamanan', [DomainPeningkatanKeamananController::class, 'searchDomainPeningkatanKeamanan'])->name('search-peningkatan-keamanan.get');
	Route::get('metadata-app', [DomainPeningkatanKeamananController::class, 'getMetadataApp'])->name('get-metadata-app');
	Route::get('metadata-netdev', [DomainPeningkatanKeamananController::class, 'getMetadataNetdev'])->name('get-metadata-netdev');
});