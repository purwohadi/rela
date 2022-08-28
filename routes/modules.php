<?php

Route::middleware(['web', 'auth'])->get('/', 'HomeController@index')->name('home');

include_route_files(__DIR__ . '/modules/');

Route::get('/{vue_capture?}', 'HomeController@index')
  ->where('vue_capture', '[\/\w\.-]*')
  // ->where('vue_capture', '^(?!(api|app|imagecache)).*$')
  ->name('home');
