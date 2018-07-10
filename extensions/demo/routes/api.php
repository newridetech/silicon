<?php

Route::prefix('/api/v1')->group(function () {
    Route::get('demo', 'Demo@index')->name('index');
});
