<?php

Route::group(['prefix' => 'ref-kemendagri', 'as' => 'ref-kemendagri.'], function () {
  Route::get('/', 'RefrensiKemendagriController@search')->name('get');
  Route::get('/ref-program', 'RefrensiKemendagriController@getRefProgram')->name('ref-program');
  Route::get('/ref-kegiatan', 'RefrensiKemendagriController@getRefKegiatan')->name('ref-kegiatan');
  Route::get('/ref-sub-kegiatan', 'RefrensiKemendagriController@getRefSubKegiatan')->name('ref-sub-kegiatan');
});
