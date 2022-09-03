<?php

use App\Http\Controllers\DownloadController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// for public route only

Route::get('timestamp', function () {
  return Str::getCurrentDate('l, d F Y H:m:s');
})->name('timestamp');

Route::group(['middleware' => 'auth'], function() {
  Route::get('clear', 'HomeController@clear')->name('clear');
  Route::get('create-pwdskt/{password}', 'HomeController@createPwdskt')->name('pwdskt.create');
});

// Route::group(['middleware' => 'basic.auth'], function() {
//   //Log Files
//   Route::get('log-files/', 'LogFilesController@index')->name('log-files.index');
//   Route::get('log-files/{filename}', 'LogFilesController@show')->name('log-files.show');
//   Route::get('log-files/{filename}/download', 'LogFilesController@download')->name('log-files.download');
//   Route::get('test-log', 'LogFilesController@testLog')->name('log-files.writetest');
// });

// Captcha Route
Route::post('/captcha-validation', 'CaptchaServiceController@capthcaFormValidate')->name('captcha-validation');
Route::get('/reload-captcha', 'CaptchaServiceController@reloadCaptcha')->name('reload-captcha')->middleware('web');;
Route::get('/audio-captcha', 'CaptchaServiceController@readAudio')->name('audio-captcha');
Route::get('/pengumuman', 'PengumumanController@getListPengumuman')->name('pengumuman');

Route::get('/media/download/{media}', [DownloadController::class, 'show'])->name('download.show');
Route::get('/media/download-alt/{params}', [DownloadController::class, 'showNonMedia'])->name('download.non-media.show');

Route::post('reset-password', 'Auth\ForgotPasswordController@resetPassword')->name('reset-password');
Route::get('{token}/reset-password', 'Auth\ResetPasswordController@showResetPasswordForm')->name('show.reset.password');
Route::post('password-update/reset-password', 'Auth\ResetPasswordController@passwordUpdate')->name('password-update');
