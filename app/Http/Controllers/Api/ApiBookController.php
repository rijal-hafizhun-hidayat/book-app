<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Book\BookService;
use App\Services\BookCategory\BookCategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiBookController extends Controller
{
    protected $bookService;
    protected $bookCategoryService;
    public function __construct(BookService $bookService, BookCategoryService $bookCategoryService)
    {
        $this->bookService = $bookService;
        $this->bookCategoryService = $bookCategoryService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'author' => ['required'],
            'background' => ['required'],
            'category' => ['required'],
            'cover' => ['required', 'file', 'mimes:jpg,png,jpeg', 'max:1024']
        ]);

        try {
            DB::beginTransaction();
            $book = $this->bookService->storeBookWithBookCategory($request);
            $this->bookCategoryService->storeBookCategory($request, $book);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json($e->getMessage());
        }

        return response()->json([
            'statusCode' => 200,
            'message' => 'success store book',
            'data' => $book
        ]);
    }
}
