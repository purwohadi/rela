<?php

Route::group(['prefix' => 'ref-tupoksi', 'as' => 'ref-tupoksi.'], function () {
  Route::get('/getTupoksi', 'RefrensiTupoksiController@search')->name('get');
  Route::get('/getOptionTupoksi', 'RefrensiTupoksiController@get_option')->name('get_option');
});
