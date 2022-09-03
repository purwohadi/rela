<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'feature-access', 'as' => 'feature-access.'], function () {
  Route::get('/', 'FeatureAccessController@search')->name('get');
  Route::get('/all', 'FeatureAccessController@all')->name('all');
  Route::get('{id}/show', 'FeatureAccessController@show')->name('show');
  Route::get('/get_parent', 'FeatureAccessController@get_parent')->name('get_parent');
  Route::post('/', 'FeatureAccessController@store')->name('store');
  Route::put('{id}/update', 'FeatureAccessController@update')->name('update');
  Route::delete('/', 'FeatureAccessController@drop')->name('drop');
  Route::post('exist', 'FeatureAccessController@exist')->name('exist');
  Route::post('exclude', 'FeatureAccessController@exclude')->name('exclude');
  Route::post('sync-role-permissions', 'FeatureAccessController@sync')->name('sync');
  Route::get('menu-used', 'FeatureAccessController@menuUsed')->name('menu-used');
});

Route::group(['prefix' => 'feature-access-group', 'as' => 'feature-access-group.'], function () {
  Route::get('/', 'FeatureAccessGroupController@search')->name('get');
  Route::get('/all', 'FeatureAccessGroupController@all')->name('all');
  Route::post('/', 'FeatureAccessGroupController@store')->name('store');
  Route::put('/', 'FeatureAccessGroupController@edit')->name('edit');
  Route::delete('/', 'FeatureAccessGroupController@drop')->name('drop');
  Route::post('exist', 'FeatureAccessGroupController@exist')->name('exist');
  Route::post('exclude', 'FeatureAccessGroupController@exclude')->name('exclude');
  Route::post('sync-role-permissions', 'FeatureAccessGroupController@sync')->name('sync');
});
