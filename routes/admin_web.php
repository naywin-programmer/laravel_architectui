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

        Route::resource('permissions', 'PermissionsController')->only(['index', 'create', 'store']);

        Route::resource('roles', 'RolesController');

        Route::resource('admin-users', 'AdminUsersController');
        Route::put('/admin-users/{admin_user}/trash', 'AdminUsersController@trash')->name('admin-users.trash');
        Route::put('/admin-users/{admin_user}/restore', 'AdminUsersController@restore')->name('admin-users.restore');

        Route::resource('client-users', 'ClientUsersController');
        Route::put('/client-users/{client_user}/trash', 'ClientUsersController@trash')->name('client-users.trash');
        Route::put('/client-users/{client_user}/restore', 'ClientUsersController@restore')->name('client-users.restore');

        Route::get('/', 'IndexController@index')->name('index');
    });

});