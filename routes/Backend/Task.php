<?php

/*
 * CMS Task Management
 */
Route::group(['namespace' => 'Tasks'], function () {
    Route::resource('tasks', 'TasksController', ['except' => ['show']]);

    //For DataTables
    Route::post('tasks/get', 'TasksTableController')->name('tasks.get');
});
