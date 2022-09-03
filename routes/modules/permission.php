<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'permission', 'as' => 'permission.'], function () {
  Route::get('/', 'PermissionController@search')->name('get');
  Route::post('/', 'PermissionController@store')->name('store');
  Route::put('/', 'PermissionController@edit')->name('edit');
  Route::delete('/', 'PermissionController@drop')->name('drop');
  Route::post('exist', 'PermissionController@exist')->name('exist');
  Route::post('exclude', 'PermissionController@exclude')->name('exclude');
});
