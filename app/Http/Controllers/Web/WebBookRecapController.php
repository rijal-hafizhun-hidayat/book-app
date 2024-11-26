<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\BookRecap\BookRecapService;
use App\Services\Category\CategoryService;
use App\Services\Publisher\PublisherService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class WebBookRecapController extends Controller
{
    protected $categoryService;
    protected $publisherService;
    protected $userService;
    protected $bookRecapService;
    public function __construct(CategoryService $categoryService, PublisherService $publisherService, UserService $userService, BookRecapService $bookRecapService)
    {
        $this->categoryService = $categoryService;
        $this->publisherService = $publisherService;
        $this->userService = $userService;
        $this->bookRecapService = $bookRecapService;
    }
    public function index()
    {
        return view('book-recap.index', [
            'publishers' => $this->publisherService->getAll(),
            'categories' => $this->categoryService->getAll(),
            'users' => $this->userService->getUserByRoleWriter()
        ]);
    }

    public function export(Request $request)
    {
        //dd($this->bookRecapService->getDataByCategory(), $this->bookRecapService->getDataByWriter(), $this->bookRecapService->getDataByPublisher());
        $pdf = PDF::loadView('export.book-recap-pdf', [
            'categories' => $this->bookRecapService->getDataByCategory(),
            'writers' => $this->bookRecapService->getDataByWriter(),
            'publishers' => $this->bookRecapService->getDataByPublisher()
        ]);

        return $pdf->stream('book-recap.pdf', array("Attachment" => false));
    }
}
