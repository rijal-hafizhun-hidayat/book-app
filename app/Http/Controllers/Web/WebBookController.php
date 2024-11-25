<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Services\Book\BookService;
use App\Services\Category\CategoryService;
use App\Services\Publisher\PublisherService;
use Illuminate\Http\Request;

class WebBookController extends Controller
{
    protected $bookService;
    protected $categoryService;
    protected $publisherService;

    public function __construct(BookService $bookService, CategoryService $categoryService, PublisherService $publisherService)
    {
        $this->bookService = $bookService;
        $this->categoryService = $categoryService;
        $this->publisherService = $publisherService;
    }

    public function index()
    {
        //dd($this->bookService->getBookWithCategoryAndPublisher());
        return view('book.index', [
            'books' => $this->bookService->getBookWithCategoryAndPublisher()
        ]);
    }

    public function create()
    {
        return view('book.create', [
            'categories' => $this->categoryService->getAll(),
            'publishers' => $this->publisherService->getAll()
        ]);
    }

    public function show($id)
    {
        $book = $this->bookService->findBookByBookId($id);
        //dd($book);
        return view('book.show', [
            'book' => $book,
            'categories' => $this->categoryService->getAll(),
            'publishers' => $this->publisherService->getAll()
        ]);
    }
}
