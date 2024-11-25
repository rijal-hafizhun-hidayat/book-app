<?php

use App\Http\Controllers\Api\ApiAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('api')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [ApiAuthController::class, 'login'])->name('api.auth.login');
    });
});
