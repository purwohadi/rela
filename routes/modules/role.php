<?php

Route::group(['prefix' => 'role', 'as' => 'role.'], function () {
  Route::get('/', 'RoleController@search')->name('get');
  Route::post('/', 'RoleController@store')->name('store');
  Route::put('/', 'RoleController@edit')->name('edit');
  Route::delete('/', 'RoleController@drop')->name('drop');
  Route::post('exist', 'RoleController@exist')->name('exist');
  Route::post('exclude', 'RoleController@exclude')->name('exclude');
  Route::post('sync-role-permissions', 'RoleController@sync')->name('sync');
});
