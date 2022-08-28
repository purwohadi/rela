<?php

Route::group(['prefix' => 'reference', 'as' => 'reference.'], function () {
  Route::get('/', 'ReferenceController@search')->name('get');
  Route::post('/', 'ReferenceController@store')->name('store');
  Route::put('/', 'ReferenceController@edit')->name('edit');
  Route::delete('/', 'ReferenceController@drop')->name('drop');
  Route::get('type/{type}', 'ReferenceController@getByType')->name('type');
  Route::post('exist', 'ReferenceController@exist')->name('exist');
  Route::post('exclude', 'ReferenceController@exclude')->name('exclude');
});

Route::group(['prefix' => 'opd', 'as' => 'opd.'], function () {
  Route::get('/', 'OpdController@list')->name('all');
  Route::post('/', 'OpdController@list')->name('save');
  Route::get('/data', 'OpdController@data')->name('data');
});
