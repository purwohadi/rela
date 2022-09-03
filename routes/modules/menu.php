<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'menu', 'as' => 'menu.'], function () {
  Route::get('/', 'MenuController@search')->name('get');
  Route::post('/', 'MenuController@store')->name('store');
  Route::put('/', 'MenuController@edit')->name('edit');
  Route::delete('/', 'MenuController@drop')->name('drop');
  Route::get('parents', 'MenuController@getParents')->name('parents');
  Route::get('used-route', 'MenuController@usedRoutes')->name('used-route');
  Route::post('exist', 'MenuController@exist')->name('exist');
  Route::post('exclude', 'MenuController@exclude')->name('exclude');
  Route::get('structure', 'MenuController@structure')->name('structure');
});
