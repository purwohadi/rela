<?php
use App\Http\Controllers\JaringanInfraJipController;
use App\Http\Controllers\PeriferalController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\MediaPenyimpananController;
use App\Http\Controllers\PerangkatJaringanController;
use App\Http\Controllers\Domain\DomainInfraSoftwareController;
use App\Http\Controllers\SplpController;
use App\Http\Controllers\DomainInfraKeamananController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'jaringan-intra-pemerintah', 'as' => 'jaringan-intra-pemerintah.'], function ()
{
	Route::get('data-intra-pemerintah', [JaringanInfraJipController::class, 'dataIntraPemerintah'])->name('data-intra-pemerintah.get');
	Route::get('get-domain-code', [JaringanInfraJipController::class, 'getDomainCode'])->name('get-domain-code.get');

	Route::post('/simpan-data-domain-infra-jip', [JaringanInfraJipController::class, 'simpanDataDomainInfraJip'])->name('simpan-data-domain-infra-jip');
	Route::post('/update-data-domain-infra-jip', [JaringanInfraJipController::class, 'updateDataDomainInfraJip'])->name('update-data-domain-infra-jip');
	Route::post('/delete-data-domain-infra-jip', [JaringanInfraJipController::class, 'deleteDataDomainInfraJip'])->name('delete-data-domain-infra-jip');
  Route::get('/search-intra-pemerintah', [JaringanInfraJipController::class, 'searchIntraPemerintah'])->name('search-intra-pemerintah.get');
	Route::get('get-data-by', [JaringanInfraJipController::class, 'getDataBy'])->name('get-data-by.get');
	Route::get('data-perangkat-daerah', [JaringanInfraJipController::class, 'dataPerangkatDaerah'])->name('data-perangkat-daerah.get');
	Route::get('data-perangkat-daerah-pemilik', [JaringanInfraJipController::class, 'dataPerangkatDaerahPemilik'])->name('data-perangkat-daerah-pemilik.get');
});

Route::group(['prefix' => 'sistem-penghubung-layanan-pemerintah', 'as' => 'sistem-penghubung-layanan-pemerintah.'], function () {
  Route::get('/', 'SistemPenghubungLayananPemerintahController@search')->name('get');
  Route::post('/delete', 'SistemPenghubungLayananPemerintahController@drop')->name('drop');
  Route::post('/', 'SistemPenghubungLayananPemerintahController@store')->name('store');
  Route::get('{id}/update', 'SistemPenghubungLayananPemerintahController@update')->name('update');
  Route::get('{id}/sistem-penghubung-layanan-pemerintah', 'SistemPenghubungLayananPemerintahController@getDataInfrastrukturSplp')->name('sistem-penghubung-layanan-pemerintah.get');
  Route::get('/get_rail1', 'SistemPenghubungLayananPemerintahController@get_rail1')->name('get_rail1');
  Route::get('/get_rail2', 'SistemPenghubungLayananPemerintahController@get_rail2')->name('get_rail2');
  Route::get('/get_rail3', 'SistemPenghubungLayananPemerintahController@get_rail3')->name('get_rail3');
  Route::get('/get_rail4/', 'SistemPenghubungLayananPemerintahController@get_rail4')->name('get_rail4');
  Route::get('/get_instansi/', 'SistemPenghubungLayananPemerintahController@get_instansi')->name('get_instansi');
  Route::get('/get_owner/', 'SistemPenghubungLayananPemerintahController@get_instansi')->name('get_owner');
  Route::get('/get_metadata/', 'SistemPenghubungLayananPemerintahController@get_metadata')->name('get_metadata');
  Route::get('/get_metadata_detail/{id?}', 'SistemPenghubungLayananPemerintahController@get_metadata_detail')->name('get_metadata_detail');
});

Route::group(['prefix' => 'jenis', 'as' => 'jenis.'], function () {
  Route::get('/', 'SistemPenghubungLayananPemerintahController@list_jenis')->name('all');
});

Route::group(['prefix' => 'app', 'as' => 'app.'], function () {
  Route::get('/', 'SistemPenghubungLayananPemerintahController@list_app')->name('all');
  Route::get('/app_connected', 'SistemPenghubungLayananPemerintahController@list_app_connected')->name('app_connected');
});

Route::group(['prefix' => 'jip', 'as' => 'jip.'], function () {
  Route::get('/', 'SistemPenghubungLayananPemerintahController@list_jip')->name('all');
});

Route::group(['prefix' => 'periferal', 'as' => 'periferal.'], function ()
{
	Route::get('data-periferal', [PeriferalController::class, 'dataIntraPheri'])->name('data-periferal.get');
	Route::post('/simpan-data-domain-infra-pheri', [PeriferalController::class, 'simpanDataDomainInfraPheri'])->name('simpan-data-domain-infra-pheri');
	Route::post('/update-data-domain-infra-pheri', [PeriferalController::class, 'updateDataDomainInfraPheri'])->name('update-data-domain-infra-pheri');
	Route::post('/delete-data-domain-infra-jpheri', [PeriferalController::class, 'deleteDataDomainInfraPheri'])->name('delete-data-domain-infra-pheri');
  	Route::get('/search-intra-periferal', [PeriferalController::class, 'searchIntraPheri'])->name('search-intra-periferal.get');
	  Route::get('data-perangkat-daerah', [PeriferalController::class, 'dataPerangkatDaerah'])->name('data-perangkat-daerah.get');
});

Route::group(['prefix' => 'media-penyimpanan', 'as' => 'media-penyimpanan.'], function ()
{
	Route::get('data-storage', [MediaPenyimpananController::class, 'dataIntraStorage'])->name('data-storage.get');
	Route::post('/simpan-data-domain-infra-storage', [MediaPenyimpananController::class, 'simpanDataDomainInfraStorage'])->name('simpan-data-domain-infra-storage');
	Route::post('/update-data-domain-infra-storage', [MediaPenyimpananController::class, 'updateDataDomainInfraStorage'])->name('update-data-domain-infra-storage');
	Route::post('/delete-data-domain-infra-storage', [MediaPenyimpananController::class, 'deleteDataDomainInfraStorage'])->name('delete-data-domain-infra-storage');
	Route::get('/search-intra-storage', [MediaPenyimpananController::class, 'searchIntraStorage'])->name('search-intra-storage.get');
	Route::get('data-storage', [MediaPenyimpananController::class, 'dataIntraStorage'])->name('data-storage.get');
	Route::get('/get_rail1', [MediaPenyimpananController::class, 'get_rail1'])->name('get_rail1');
	Route::get('/get_rail2', [MediaPenyimpananController::class, 'get_rail2'])->name('get_rail2');
	Route::get('/get_rail3', [MediaPenyimpananController::class, 'get_rail3'])->name('get_rail3');
	Route::get('/get_rail4', [MediaPenyimpananController::class, 'get_rail4'])->name('get_rail4');
	Route::get('/get_detail_instansi', [MediaPenyimpananController::class, 'get_detail_instansi'])->name('get_detail_instansi');
	Route::get('metadataKeamananGet', [MediaPenyimpananController::class, 'metadataKeamananGet'])->name('metadata_keamanan.get');
	Route::get('metadataSplpGet', [MediaPenyimpananController::class, 'metadataSplpGet'])->name('metadata_splp.get');
});

Route::group(['prefix' => 'fasilitas', 'as' => 'fasilitas.'], function ()
{
	Route::get('get-domain-code', [FasilitasController::class, 'getDomainCode'])->name('get-domain-code.get');

	Route::get('/data-domain-infra-fasilitas', [FasilitasController::class, 'dataIntraFasilitas'])->name('data-domain-infra-fasilitas.get');
	Route::post('/simpan-data-domain-infra-fasilitas', [FasilitasController::class, 'simpanDataDomainInfraFasilitas'])->name('simpan-data-domain-infra-fasilitas');
	Route::post('/update-data-domain-infra-fasilitas', [FasilitasController::class, 'updateDataDomainInfraFasilitas'])->name('update-data-domain-infra-fasilitas');
	Route::post('/delete-data-domain-infra-fasilitas', [FasilitasController::class, 'deleteDataDomainInfraFasilitas'])->name('delete-data-domain-infra-fasilitas');
  	Route::get('/search-intra-fasilitas', [FasilitasController::class, 'searchIntraFasilitas'])->name('search-intra-fasilitas.get');
	Route::get('get-data-by', [FasilitasController::class, 'getDataBy'])->name('get-data-by.get');
	Route::get('/data-perangkat-daerah-instansi-lain', [FasilitasController::class, 'dataPerangkatDaerahInstansiLain'])->name('data-perangkat-daerah-instansi-lain');
});

Route::group(['prefix' => 'perangkat-lunak', 'as' => 'perangkat-lunak.'], function ()
{
	Route::get('get-data-by', [DomainInfraSoftwareController::class, 'getDataBy'])->name('get-data-by.get');
  Route::get('get-metadata_keamanan', [DomainInfraSoftwareController::class, 'getMetadataKeamanan'])->name('get-metadata-keamanan-by.get');
  Route::get('get-metadata_splp', [DomainInfraSoftwareController::class, 'getMetadataSplp'])->name('get-metadata-splp-by.get');
});

Route::group(['prefix' => 'splp', 'as' => 'splp.'], function ()
{
	Route::get('get-data-by', [SplpController::class, 'getDataBy'])->name('get-data-by.get');
});


Route::group(['prefix' => 'perangkat-jaringan', 'as' => 'perangkat-jaringan.'], function ()
{
	Route::get('data-perangkat-jaringan', [PerangkatJaringanController::class, 'dataIntraNetdev'])->name('data-netdev.get');
	Route::post('/simpan-data-domain-infra-netdev', [PerangkatJaringanController::class, 'simpanDataDomainInfraNetdev'])->name('simpan-data-domain-infra-netdev');
	Route::post('/update-data-domain-infra-netdev', [PerangkatJaringanController::class, 'updateDataDomainInfraNetdev'])->name('update-data-domain-infra-netdev');
	Route::post('/delete-data-domain-infra-netdev', [PerangkatJaringanController::class, 'deleteDataDomainInfraNetdev'])->name('delete-data-domain-infra-netdev');
  Route::get('/search-intra-netdev', [PerangkatJaringanController::class, 'searchIntraNetdev'])->name('search-intra-netdev.get');
  Route::get('/get_rail1', [PerangkatJaringanController::class, 'get_rail1'])->name('get_rail1');
  Route::get('/get_rail2', [PerangkatJaringanController::class, 'get_rail2'])->name('get_rail2');
  Route::get('/get_rail3', [PerangkatJaringanController::class, 'get_rail3'])->name('get_rail3');
  Route::get('/get_rail4', [PerangkatJaringanController::class, 'get_rail4'])->name('get_rail4');
  Route::get('/get_instansi1', [PerangkatJaringanController::class, 'get_instansi1'])->name('get_instansi1');
  Route::get('/get_instansi2', [PerangkatJaringanController::class, 'get_instansi2'])->name('get_instansi2');
  Route::get('/get_metadata_jip/{id?}', [PerangkatJaringanController::class, 'get_metadata_jip'])->name('get_metadata_jip');
  Route::get('/get_metadata_fasilitas/{id?}', [PerangkatJaringanController::class, 'get_metadata_fasilitas'])->name('get_metadata_fasilitas');
  Route::get('data-perangkat-daerah', [PerangkatJaringanController::class, 'dataPerangkatDaerah'])->name('data-perangkat-daerah.get');
});

//perangkat keamanan
Route::group(['prefix' => 'perangkat-keamanan', 'as' => 'perangkat-keamanan.'], function ()
{
	Route::get('data-perangkat-keamanan', [DomainInfraKeamananController::class, 'dataInfraKeamanan'])->name('data-perangkat-keamanan.get');
	Route::post('/simpan-data-perangkat-keamanan', [DomainInfraKeamananController::class, 'simpanDataDomainInfraKeamanan'])->name('simpan-data-domain-infra-keamanan');
	Route::post('/update-data-perangkat-keamanan', [DomainInfraKeamananController::class, 'updateDataDomainInfraKeamanan'])->name('update-data-domain-infra-keamanan');
	Route::post('/delete-data-perangkat-keamanan', [DomainInfraKeamananController::class, 'deleteDataDomainInfraKeamanan'])->name('delete-data-domain-infra-keamanan');
  	Route::get('/search-perangkat-keamanan', [DomainInfraKeamananController::class, 'searchInfraKeamanan'])->name('search-infra-keamanan.get');
	Route::get('metadata', [DomainInfraKeamananController::class, 'getMetadata'])->name('get-metadata');
});
