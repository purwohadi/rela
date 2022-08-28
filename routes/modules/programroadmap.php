<?php

Route::group(['prefix' => 'program-roadmap', 'as' => 'program-roadmap.'], function () {
    Route::get('/', 'ProgramRoadmapController@getProgramRoadmap')->name('program-by-bidur');
    Route::post('/save', 'ProgramRoadmapController@save')->name('save');
    Route::post('/update', 'ProgramRoadmapController@update')->name('edit');
});
