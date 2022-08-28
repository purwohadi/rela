<?php
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

// Route::group(['prefix' => 'profil', 'as' => 'profil.'], function ()
// {
// 	Route::get('data-bulanan', [ProfilController::class, 'dataBulananSearch'])->name('data-bulanan.get');
// 	Route::get('data-thbl/{nrk}/{thbl}', [ProfilController::class, 'dataBulananPrevNext'])->name('data-thbl.get');
// 	Route::get('data-atasan/{nrk}/{thbl}', [ProfilController::class, 'dataAtasanSearch'])->name('data-atasan.get');
// 	Route::get('data-atasan-semua-triwulan/{nrk}', [ProfilController::class, 'getAtasanForAllTW'])->name('data-atasan-semua-triwulan.get');

// 	Route::get('riwayat-hukdis/{nrk}', [ProfilController::class, 'search'])->name('riwayat-hukdis.show');
// 	Route::get('riwayat-jabatan/{nrk}', [ProfilController::class, 'searchRiwayatJabatan'])->name('riwayat-jabatan.show');
// 	Route::get('pendidikan-formal/{nrk}', [ProfilController::class, 'searchPendidikanFormal'])->name('pendidikan-formal.show');
// 	Route::get('data-pegawai/{nrk}', [ProfilController::class, 'dataPegawaiProfile'])->name('data-pegawai.get');
// 	Route::get('data-profil-pegawai/{nrk}', [ProfilController::class, 'dataPegawaiProfileSimpeg'])->name('data-pegawai.get-profile');
// 	Route::get('jenis-pendidikan-formal/{nrk}', [ProfilController::class, 'searchJenisPendidikanFormal'])->name('jenis-pendidikan-formal-get');
// 	Route::post('store-pendidikan-formal', [ProfilController::class, 'storePendidikanFormal'])->name('store-pendidikan-formal');
// 	Route::delete('delete-pendidikan-formal', [ProfilController::class, 'deletePendidikanFormal'])->name('delete-pendidikan-formal');
// 	Route::post('update-pendidikan-formal', [ProfilController::class, 'updatePendidikanFormal'])->name('update-pendidikan-formal');
// 	Route::get('pendidikan-non-formal/{nrk}', [ProfilController::class, 'searchPendidikanNonFormal'])->name('pendidikan-non-formal.show');
// 	Route::get('jenis-pendidikan-non-formal/{nrk}', [ProfilController::class, 'searchJenisPendidikanNonFormal'])->name('jenis-pendidikan-non-formal-get');
// 	Route::post('store-pendidikan-non-formal', [ProfilController::class, 'storePendidikanNonFormal'])->name('store-pendidikan-non-formal');
// 	Route::delete('delete-pendidikan-non-formal', [ProfilController::class, 'deletePendidikanNonFormal'])->name('delete-pendidikan-non-formal');
// 	Route::post('update-pendidikan-non-formal', [ProfilController::class, 'updatePendidikanNonFormal'])->name('update-pendidikan-non-formal');

// 	Route::get('narsum/{nrk}', [ProfilController::class, 'searchNarsum'])->name('narsum.show');
// 	Route::post('store-narsum', [ProfilController::class, 'storeNarsum'])->name('store-narsum');
// 	Route::delete('delete-narsum', [ProfilController::class, 'deleteNarsum'])->name('delete-narsum');
// 	Route::post('update-narsum', [ProfilController::class, 'updateNarsum'])->name('update-narsum');

// 	Route::get('kegiatan-strategis/{nrk}', [ProfilController::class, 'searchKegiatanStrategis'])->name('kegiatan-strategis.show');
// 	Route::get('jenis-kegiatan/{tahun}', [ProfilController::class, 'searchJenisKegiatan'])->name('jenis-kegiatan-get');
// 	Route::post('store-kegiatan-strategis', [ProfilController::class, 'storeKegiatanStrategis'])->name('store-kegiatan-strategis');
// 	Route::delete('delete-kegiatan-strategis', [ProfilController::class, 'deleteKegiatanStrategis'])->name('delete-kegiatan-strategis');
// 	Route::post('update-kegiatan-strategis', [ProfilController::class, 'updateKegiatanStrategis'])->name('update-kegiatan-strategis');

// 	Route::get('prestasi-jabatan/{nrk}', [ProfilController::class, 'searchPrestasiJabatan'])->name('prestasi-jabatan.show');
// 	Route::get('jenis-jabatan/{nrk}', [ProfilController::class, 'searchJenisJabatan'])->name('jenis-jabatan-get');
// 	Route::post('store-prestasi-jabatan', [ProfilController::class, 'storePrestasiJabatan'])->name('store-prestasi-jabatan');
// 	Route::delete('delete-prestasi-jabatan', [ProfilController::class, 'deletePrestasiJabatan'])->name('delete-prestasi-jabatan');
// 	Route::post('update-prestasi-jabatan', [ProfilController::class, 'updatePrestasiJabatan'])->name('update-prestasi-jabatan');
// });
