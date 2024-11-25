<?php

namespace App\Services\Book;

use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use LaravelEasyRepository\ServiceApi;

class BookServiceImplement extends ServiceApi implements BookService
{
  protected $mainRepository;

  public function __construct(Book $mainRepository)
  {
    $this->mainRepository = $mainRepository;
  }

  public function getBookWithCategory()
  {
    return $this->mainRepository->with('bookCategory.category')->get();
  }

  public function storeBookWithBookCategory($request)
  {
    $filePath = Storage::disk('public')->putFile('cover', $request->file('cover'));
    $book = $this->mainRepository->create([
      'title' => $request->title,
      'author' => $request->author,
      'background' => $request->background,
      'cover' => $filePath
    ]);

    return $book;
  }

  // Define your custom methods :)
}
