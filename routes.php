<?php

    Route::group(['middleware' => 'token'], function () {
        Route::get('/martin/birthdays/cron/{token}', ['as' => 'birthdays.cron', 'uses' => 'Martin\Birthdays\Controllers\CronController@cron']);
    });