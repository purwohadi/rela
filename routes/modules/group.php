<?php
	use Illuminate\Support\Facades\Route;

	Route::group(['prefix' => 'group', 'as' => 'group.'], function () {
	Route::get('/', 'GroupController@search')->name('get');
	Route::get('/get_group', 'GroupController@get_group_for_users')->name('get_group');
	Route::post('/', 'GroupController@store')->name('store');
	Route::put('{id}/edit', 'GroupController@edit')->name('edit');
	Route::delete('/', 'GroupController@drop')->name('drop');
	Route::get('{id}/show', 'GroupController@show')->name('show');
	Route::get('/getAll', 'GroupController@showAll')->name('all');
});
