<?php

namespace App\Services\BookCategory;

use App\Models\BookCategory;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\BookCategory\BookCategoryRepository;

class BookCategoryServiceImplement extends ServiceApi implements BookCategoryService
{

  protected $mainRepository;

  public function __construct(BookCategory $mainRepository)
  {
    $this->mainRepository = $mainRepository;
  }

  public function storeBookCategory($request, $book)
  {
    foreach ($request->category as $categoryId) {
      $this->mainRepository->create([
        'book_id' => $book->id,
        'category_id' => $categoryId
      ]);
    }
  }

  public function destroyBookCategoryByBookId($bookId)
  {
    return $this->mainRepository->where('book_id', $bookId)->delete();
  }

  // Define your custom methods :)
}
