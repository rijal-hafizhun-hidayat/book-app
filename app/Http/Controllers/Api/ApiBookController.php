<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Book\BookService;
use App\Services\BookCategory\BookCategoryService;
use App\Services\BookPublisher\BookPublisherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiBookController extends Controller
{
    protected $bookService;
    protected $bookCategoryService;
    protected $bookPublisherService;
    public function __construct(BookService $bookService, BookCategoryService $bookCategoryService, BookPublisherService $bookPublisherService)
    {
        $this->bookService = $bookService;
        $this->bookCategoryService = $bookCategoryService;
        $this->bookPublisherService = $bookPublisherService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'author' => ['required'],
            'background' => ['required'],
            'category' => ['required'],
            'publisher' => ['required'],
            'cover' => ['required', 'file', 'mimes:jpg,png,jpeg', 'max:1024']
        ]);

        try {
            DB::beginTransaction();
            $book = $this->bookService->storeBookWithBookCategory($request);
            $this->bookCategoryService->storeBookCategory($request, $book);
            $this->bookPublisherService->storeBookPublisher($request, $book);
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

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $book = $this->bookService->findBookByBookId($id);
            $this->bookService->destroyBookWithBookId($book);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json($e->getMessage());
        }

        return response()->json([
            'statusCode' => 200,
            'message' => 'success destroy book',
            'data' => $book
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required'],
            'author' => ['required'],
            'background' => ['required'],
            'category' => ['nullable'],
            'publisher' => ['required'],
            'cover' => ['nullable', 'file', 'mimes:jpg,png,jpeg', 'max:1024']
        ]);

        try {
            DB::beginTransaction();
            $book = $this->bookService->findBookByBookId($id);
            $bookUpdated = $this->bookService->updateBookWithBookCategoryByBookId($request, $book);

            if ($request->category) {
                $this->bookCategoryService->destroyBookCategoryByBookId($book->id);
                $this->bookCategoryService->storeBookCategory($request, $book);
            }
            if ($request->publisher) {
                $this->bookPublisherService->destroyBookPublisherByBookId($book->id);
                $this->bookPublisherService->storeBookPublisher($request, $book);
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json($e->getMessage());
        }

        return response()->json([
            'statusCode' => 200,
            'message' => 'success update book',
            'data' => $bookUpdated
        ]);
    }
}
