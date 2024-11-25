<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BookCategory;
use Illuminate\Http\Request;

class WebBookCategoryController extends Controller
{
    public function index()
    {
        return view('book-category.index', [
            'book_category' => BookCategory::all()
        ]);
    }
}
