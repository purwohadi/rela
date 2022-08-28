<?php
use App\Http\Controllers\DomainController;
use App\Http\Controllers\Domain\DomainInfraSoftwareController;
use App\Http\Controllers\Domain\DomainInfraServerController;
use App\Http\Controllers\DomainAplikasiController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'domain', 'as' => 'domain.'], function ()
{
	Route::get('data-perangkat-daerah', [DomainController::class, 'dataPerangkatDaerah'])->name('data-perangkat-daerah.get');
  Route::get('data-perangkat-daerah-byslug', [DomainController::class, 'dataPerangkatDaerahBySlug'])->name('data-perangkat-daerah-byslug.get');
	Route::get('/get-domain-layanan', [DomainController::class,'getDomainLayanan'])->name('get-domain-layanan');
	Route::post('/delete-data-domain-layanan', [DomainController::class, 'deleteDataDomainLayanan'])->name('delete-data-domain-layanan');
	Route::get('data-proses-bisnis', [DomainController::class, 'dataProsesBisnis'])->name('data-proses-bisnis.get');
  Route::get('data-ral', [DomainController::class, 'searchRal'])->name('data-ral.get');
  Route::get('data-ref', [DomainController::class, 'searchRef'])->name('data-ref.get');
	Route::post('/simpan-data-domain-layanan', [DomainController::class, 'simpanDataDomainLayanan'])->name('simpan-data-domain-layanan');
	Route::get('/data-domain-layanan-get', [DomainController::class, 'dataDomainLayanan'])->name('data-domain-layanan.get');
  Route::post('/update-data-domain-layanan', [DomainController::class, 'updateDataDomainLayanan'])->name('update-data-domain-layanan');
  Route::get('/get-layanan-detail', [DomainController::class,'getLayananDetail'])->name('getLayananDetail');
  Route::get('/get-layanan-detail-byid', [DomainController::class,'getLayananDetailById'])->name('get-layanan-detail-by-id');
  Route::post('/simpan-layanan-detail', [DomainController::class, 'simpanLayananDetail'])->name('simpan-layanan-detail');
  Route::post('/ubah-layanan-detail', [DomainController::class, 'ubahLayananDetail'])->name('ubah-layanan-detail');
	Route::post('/delete-data-domain-layanan-detail', [DomainController::class, 'deleteDataDomainLayananDetail'])->name('delete-data-domain-layanan-detail');
  Route::get('/data-layanan', [DomainController::class, 'getDataLayananUnique'])->name('data-layanan.get');
  Route::get('/data-jabatan-tropd-eselon3', [DomainController::class, 'getJabatanTropdEselon3'])->name('data-jabatan-tropd-eselon3');
  Route::get('/data-jabatan-tropd-eselon4', [DomainController::class, 'getJabatanTropdEselon4'])->name('data-jabatan-tropd-eselon4');
});

Route::group(['prefix' => 'domain-proses', 'as' => 'domain-proses.'], function () {
  Route::get('/getDomainProses', 'DomainProsesBisnisController@search')->name('get');
  Route::post('/', 'DomainProsesBisnisController@store')->name('store');
  Route::get('{proses_id}/update', 'DomainProsesBisnisController@update')->name('update');
  Route::get('/get_rabl/{level?}', 'DomainProsesBisnisController@get_rabl')->name('get_rabl');
  Route::get('/get_rabl_2', 'DomainProsesBisnisController@get_rabl2')->name('get_rabl2');
  Route::get('/get_rabl_3', 'DomainProsesBisnisController@get_rabl3')->name('get_rabl3');
  Route::get('/get_program', 'DomainProsesBisnisController@get_program')->name('get_program');
  Route::get('/get_rabl_4', 'DomainProsesBisnisController@get_rabl4')->name('get_rabl4');
  Route::post('/delete', 'DomainProsesBisnisController@drop')->name('drop');
  Route::get('/get_urusan', 'DomainProsesBisnisController@get_urusan')->name('get_urusan');
  Route::get('{proses_id}/data-proses-bisnis', 'DomainProsesBisnisController@getDataDomainProses')->name('data-proses-bisnis.get');
});

Route::group(['prefix' => 'domain-infrastruktur-cloud', 'as' => 'domain-infrastruktur-cloud.'], function () {
  Route::get('/', 'DomainInfrastrukturCloudController@search')->name('get');
  Route::post('/delete', 'DomainInfrastrukturCloudController@drop')->name('drop');
  Route::get('{id}/data-infrastruktur-cloud', 'DomainInfrastrukturCloudController@getDataInfrastrukturCloud')->name('data-infrastruktur-cloud.get');
  Route::post('/', 'DomainInfrastrukturCloudController@store')->name('store');
  Route::get('{id}/update', 'DomainInfrastrukturCloudController@update')->name('update');
  Route::get('/get_metadata', 'DomainInfrastrukturCloudController@get_metadata')->name('getMetadata');
  Route::get('/get_rail/{level?}', 'DomainInfrastrukturCloudController@get_rail')->name('get_rail');
  Route::get('/get_rail1', 'DomainInfrastrukturCloudController@get_rail1')->name('get_rail1');
  Route::get('/get_rail2', 'DomainInfrastrukturCloudController@get_rail2')->name('get_rail2');
  Route::get('/get_rail3/{rail3?}', 'DomainInfrastrukturCloudController@get_rail3')->name('get_rail3');
  Route::get('/get_metadata_detail/{id?}', 'DomainInfrastrukturCloudController@get_metadata_detail')->name('get_metadata');
  Route::get('data-perangkat-daerah', 'DomainInfrastrukturCloudController@dataPerangkatDaerah')->name('data-perangkat-daerah.get');
});

Route::group(['prefix' => 'instansi', 'as' => 'instansi.'], function () {
  Route::get('/', 'DomainInfrastrukturCloudController@list_instansi')->name('all');
});

Route::group(['prefix' => 'tipe', 'as' => 'tipe.'], function () {
  Route::get('/', 'DomainInfrastrukturCloudController@list_tipe')->name('all');
});

Route::group(['prefix' => 'owner', 'as' => 'owner.'], function () {
  Route::get('/', 'DomainInfrastrukturCloudController@list_owner')->name('all');
});


Route::group(['prefix' => 'domain-infra-software', 'as' => 'domain-infra-software.'], function () {
  Route::get('/', [DomainInfraSoftwareController::class, 'listData'])->name('list');
  Route::get('/detail/{id}', [DomainInfraSoftwareController::class, 'show'])->name('show');
  Route::delete('/delete/{id}', [DomainInfraSoftwareController::class, 'delete'])->name('delete');
  Route::post('/update/{id}', [DomainInfraSoftwareController::class, 'update'])->name('update');
  Route::post('/save', [DomainInfraSoftwareController::class, 'save'])->name('save');
  Route::get('/software/used', [DomainInfraSoftwareController::class, 'getUsedSoftware'])->name('get_used_software');
});

Route::group(['prefix' => 'domain-infra-server', 'as' => 'domain-infra-server.'], function () {
  Route::get('/', [DomainInfraServerController::class, 'listData'])->name('list');
  Route::get('/detail/{id}', [DomainInfraServerController::class, 'show'])->name('show');
  Route::post('/delete', [DomainInfraServerController::class, 'delete'])->name('delete');
  Route::post('/update', [DomainInfraServerController::class, 'update'])->name('update');
  Route::post('/save', [DomainInfraServerController::class, 'save'])->name('save');
});

Route::group(['prefix' => 'domain-data-informasi', 'as' => 'domain-data-informasi.'], function () {
  Route::get('/getDomainDataInfo', 'DomainDataInfromasiController@search')->name('get');
  Route::get('/get_radl1', 'DomainDataInfromasiController@get_radl1')->name('get_radl1');
  Route::get('/get_radl2', 'DomainDataInfromasiController@get_radl2')->name('get_radl2');
  Route::get('/get_radl3', 'DomainDataInfromasiController@get_radl3')->name('get_radl3');
  Route::get('/get_probis_terkait', 'DomainDataInfromasiController@get_probis_terkait')->name('get_probis_terkait');
  Route::post('/', 'DomainDataInfromasiController@store')->name('store');
  Route::get('{info_id}/data-informasi', 'DomainDataInfromasiController@getDataInformasi')->name('data-informasi.get');
  Route::get('/get_detail_data', 'DomainDataInfromasiController@get_detail_data')->name('get_detail_data');
  Route::get('{info_id}/update', 'DomainDataInfromasiController@update')->name('update');
  Route::post('/store_detail', 'DomainDataInfromasiController@store_detail')->name('store_detail');
  Route::get('{id}/getDetailDataInformasi', 'DomainDataInfromasiController@getDetailDataInformasi')->name('detail-data-informasi.get');
  Route::get('{id}/get_probis_data', 'DomainDataInfromasiController@get_probis_data')->name('get_probis_data');
  Route::get('{id}/update_detail', 'DomainDataInfromasiController@update_detail')->name('update_detail');
  Route::post('/delete_detail', 'DomainDataInfromasiController@drop_detail')->name('drop_detail');
  Route::post('/delete', 'DomainDataInfromasiController@drop')->name('drop');
  Route::get('/get-data-master', 'DomainDataInfromasiController@getDataUnique')->name('get-data-master');
});

Route::group(['prefix' => 'domain-aplikasi', 'as' => 'domain-aplikasi.'], function () {
  Route::get('/', [DomainAplikasiController::class, 'listData'])->name('list');
  Route::get('/data-aplikasi', [DomainAplikasiController::class, 'getDataAplikasi'])->name('data-aplikasi');
  Route::get('/detail/{id}', [DomainAplikasiController::class, 'show'])->name('show');
  Route::post('/delete', [DomainAplikasiController::class, 'delete'])->name('delete');
  Route::post('/update', [DomainAplikasiController::class, 'update'])->name('update');
  Route::post('/save', [DomainAplikasiController::class, 'save'])->name('save');
  Route::get('/aplikasi-detail', [DomainAplikasiController::class, 'getAplikasiDetail'])->name('get-aplikasi-detail');
});
