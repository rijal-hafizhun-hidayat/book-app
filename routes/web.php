<?php

use App\Http\Controllers\Web\WebBookCategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::prefix('book-category')->group(function () {
    Route::get('/', [WebBookCategoryController::class, 'index'])->name('book-category.index');
});
