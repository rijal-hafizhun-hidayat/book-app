<?php

namespace App\Services\BookPublisher;

use App\Models\BookPublisher;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\BookPublisher\BookPublisherRepository;

class BookPublisherServiceImplement extends ServiceApi implements BookPublisherService
{
  protected $mainRepository;

  public function __construct(BookPublisher $mainRepository)
  {
    $this->mainRepository = $mainRepository;
  }

  public function storeBookPublisher($request, $book)
  {
    return $this->mainRepository->create([
      'book_id' => $book->id,
      'publisher_id' => $request->publisher
    ]);
  }

  public function destroyBookPublisherByBookId($bookId)
  {
    return $this->mainRepository->where('book_id', $bookId)->delete();
  }

  // Define your custom methods :)
}
