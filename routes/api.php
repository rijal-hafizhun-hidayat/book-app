<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiBookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
    Route::post('login', [ApiAuthController::class, 'login'])->name('api.auth.login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('book')->group(function () {
        Route::post('/', [ApiBookController::class, 'store'])->name('api.book.store');
        Route::delete('/{id}', [ApiBookController::class, 'destroy'])->name('api.book.destroy');
        Route::post('/{id}/update', [ApiBookController::class, 'update'])->name('api.book.update');
    });
});
