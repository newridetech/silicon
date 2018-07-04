<?php

Route::prefix('/')->group(function () {
    Route::get('', 'Demo@index')->name('index');
});
