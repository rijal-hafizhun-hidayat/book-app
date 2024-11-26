<?php

use App\Http\Controllers\Web\WebAuthController;
use App\Http\Controllers\Web\WebCategoryController;
use App\Http\Controllers\Web\WebBookController;
use App\Http\Controllers\Web\WebBookRecapController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('/');

Route::prefix('category')->group(function () {
    Route::get('/', [WebCategoryController::class, 'index'])->name('book-category.index');
});

Route::post('login', [WebAuthController::class, 'login'])->name('login');

Route::middleware('auth')->group(function () {
    Route::prefix('book')->group(function () {
        Route::get('/', [WebBookController::class, 'index'])->name('book.index');
        Route::get('/create', [WebBookController::class, 'create'])->name('book.create')->middleware('admin');
        Route::get('/{id}', [WebBookController::class, 'show'])->name('book.show')->middleware('admin');
    });

    Route::middleware('admin')->group(function () {
        Route::prefix('book-recap')->group(function () {
            Route::get('/', [WebBookRecapController::class, 'index'])->name('book-recap.index');
            Route::post('/book-recap', [WebBookRecapController::class, 'export'])->name('book-recap.export');
        });
    });

    Route::get('logout', [WebAuthController::class, 'logout'])->name('logout');
});
