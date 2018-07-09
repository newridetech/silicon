<?php

Route::prefix('/api/v1')->group(function () {
    Route::get('', 'Demo@index')->name('index');
});
