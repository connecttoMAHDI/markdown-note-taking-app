<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'v1'
], function () {
    require_once __DIR__ . '/v1/note.php';
});
