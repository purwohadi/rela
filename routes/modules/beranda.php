<?php
	use Illuminate\Support\Facades\Route;

	Route::group(['prefix' => 'beranda', 'as' => 'beranda.'], function () {
	Route::get('/get-dpt', 'DashboardController@getDpt')->name('get-dpt');
});
