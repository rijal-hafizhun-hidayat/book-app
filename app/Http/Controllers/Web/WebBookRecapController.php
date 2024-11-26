<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\Category\CategoryService;
use App\Services\Publisher\PublisherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebBookRecapController extends Controller
{
    protected $categoryService;
    protected $publisherService;
    public function __construct(CategoryService $categoryService, PublisherService $publisherService)
    {
        $this->categoryService = $categoryService;
        $this->publisherService = $publisherService;
    }
    public function index()
    {
        return view('book-recap.index', [
            'publishers' => $this->publisherService->getAll(),
            'categories' => $this->categoryService->getAll()
        ]);
    }
}
