<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'success' => true,
        'message' => 'API server is running',
        'docs' => env('APP_URL') . '/docs/api',
    ]);
});
