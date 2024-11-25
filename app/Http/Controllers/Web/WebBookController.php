<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Services\Book\BookService;
use App\Services\Category\CategoryService;
use Illuminate\Http\Request;

class WebBookController extends Controller
{
    protected $bookService;
    protected $categoryService;

    public function __construct(BookService $bookService, CategoryService $categoryService)
    {
        $this->bookService = $bookService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return view('book.index', [
            'books' => $this->bookService->getBookWithCategory()
        ]);
    }

    public function create()
    {
        return view('book.create', [
            'categories' => $this->categoryService->getAll()
        ]);
    }

    public function show($id)
    {
        $book = $this->bookService->findBookByBookId($id);
        //dd($book);
        return view('book.show', [
            'book' => $book,
            'categories' => $this->categoryService->getAll()
        ]);
    }
}
