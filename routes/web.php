<?php

Route::group([
    'namespace' => 'app\Http\Controllers\Auth',
], function () {
    Route::get('check', 'CheckController@index')->name('check');
    Route::get('login', 'LoginController@index')->name('login');
    Route::get('password', 'ResetPasswordController@index')->name('password.request');
    Route::get('register', 'RegisterController@index')->name('register');
    Route::post('logout', 'LogoutController@index')->name('logout');
});
