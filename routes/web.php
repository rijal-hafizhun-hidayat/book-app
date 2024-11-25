<?php

use App\Http\Controllers\Web\WebCategoryController;
use App\Http\Controllers\Web\WebBookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::prefix('category')->group(function () {
    Route::get('/', [WebCategoryController::class, 'index'])->name('book-category.index');
});

Route::prefix('book')->group(function () {
    Route::get('/', [WebBookController::class, 'index'])->name('book.index');
    Route::get('/create', [WebBookController::class, 'create'])->name('book.create');
});
