<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Services\Book\BookService;
use App\Services\BookCategory\BookCategoryService;
use App\Services\BookPublisher\BookPublisherService;
use App\Services\BookWriter\BookWriterService;
use App\Services\Category\CategoryService;
use App\Services\Publisher\PublisherService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WebBookController extends Controller
{
    protected $bookService;
    protected $categoryService;
    protected $publisherService;
    protected $userService;
    protected $bookWriterService;
    protected $bookCategoryService;
    protected $bookPublisherService;

    public function __construct(BookService $bookService, CategoryService $categoryService, PublisherService $publisherService, UserService $userService, BookWriterService $bookWriterService, BookCategoryService $bookCategoryService, BookPublisherService $bookPublisherService)
    {
        $this->bookService = $bookService;
        $this->categoryService = $categoryService;
        $this->publisherService = $publisherService;
        $this->userService = $userService;
        $this->bookWriterService = $bookWriterService;
        $this->bookCategoryService = $bookCategoryService;
        $this->bookPublisherService = $bookPublisherService;
    }

    public function index()
    {
        return view('book.index', [
            'books' => $this->bookService->getBookWithCategoryAndPublisherAndWriter(),
            'users' => $this->userService->getUserByRoleWriter(),
            'categories' => $this->categoryService->getAll(),
            'publishers' => $this->publisherService->getAll()
        ]);
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
            $this->bookWriterService->storeBookWriter($request, $book);
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required'],
            'author' => ['nullable'],
            'background' => ['required'],
            'category' => ['nullable'],
            'publisher' => ['required'],
            'cover' => ['nullable', 'file', 'mimes:jpg,png,jpeg', 'max:1024']
        ]);

        //dd($request->all());

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
            if ($request->author) {
                $this->bookWriterService->destroyBookWriterByBookId($book->id);
                $this->bookWriterService->storeBookWriter($request, $book);
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

    public function create()
    {
        return view('book.create', [
            'categories' => $this->categoryService->getAll(),
            'publishers' => $this->publisherService->getAll(),
            'users' => $this->userService->getUserByRoleWriter()
        ]);
    }

    public function show($id)
    {
        $book = $this->bookService->findBookByBookId($id);
        //dd($book);
        return view('book.show', [
            'book' => $book,
            'categories' => $this->categoryService->getAll(),
            'publishers' => $this->publisherService->getAll(),
            'users' => $this->userService->getUserByRoleWriter()
        ]);
    }
}
