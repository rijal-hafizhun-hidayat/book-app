<?php

namespace App\Services\BookWriter;

use App\Models\BookWriter;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\BookWriter\BookWriterRepository;

class BookWriterServiceImplement extends ServiceApi implements BookWriterService
{
  protected $mainRepository;

  public function __construct(BookWriter $mainRepository)
  {
    $this->mainRepository = $mainRepository;
  }

  public function storeBookWriter($request, $book)
  {
    foreach ($request->author as $authorId) {
      $this->mainRepository->create([
        'book_id' => $book->id,
        'user_id' => $authorId
      ]);
    }
  }

  public function destroyBookWriterByBookId($bookId)
  {
    return $this->mainRepository->where('book_id', $bookId)->delete();
  }

  // Define your custom methods :)
}
