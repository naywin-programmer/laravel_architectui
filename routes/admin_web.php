<?php

Route::name('admin.')
    ->prefix(config('app.prefix_admin_url') . '/admin')
    ->namespace('Backend\Admin')
    ->group(function () {

    // Auth
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'Auth\LoginController@login')->name('login');

    Route::middleware(['auth:admin'])->group(function () {
        Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
        Route::get('/', 'IndexController@index')->name('index');
    });

});