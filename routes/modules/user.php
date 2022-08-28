<?php

  Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('/', 'UserController@search')->name('get');
    Route::post('/', 'UserController@store')->name('store');
    Route::put('{id}/update', 'UserController@update')->name('update');
    Route::delete('/', 'UserController@drop')->name('drop');
    Route::get('{id}/show', 'UserController@show')->name('show');
    Route::post('change-password', 'UserController@changePassword')->name('change-password');
    Route::post('change-session', 'UserController@changeSession')->name('change-session');
    Route::post('impersonate/{role}', 'UserController@impersonate')->name('impersonate');
    Route::post('leave-impersonate', 'UserController@leaveImpersonate')->name('leave-impersonate');
    Route::get('/get-data-profil', 'UserController@getDataProfil')->name('get-data-profil');
    Route::post('change-password-admin-pdukpd', 'UserController@changePasswordAdminPdukpd')->name('change-password-admin-pdukpd');
    Route::post('check', 'UserController@checkCurrentPassword')->name('check-current-password');
  });


