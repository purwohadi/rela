<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('basic.auth')
    ->get('user-authorize', 'Auth\LoginController@userAuthorize')
    ->name('api.login.eabsensi');

Route::middleware('basic.auth', 'throttle:5,1')
    ->post('user-authorize', 'Auth\LoginController@tempUserAuthorize')
    ->name('api.login.temporary');
