<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::get('/login', 'login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Route::get('/users', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
