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

  public function getBookWithCategoryAndPublisherAndWriter()
  {
    return $this->mainRepository->with(['bookCategory.category', 'bookPublisher.publisher', 'bookWriter.user'])->get();
  }

  public function storeBookWithBookCategory($request)
  {
    $filePath = Storage::disk('public')->putFile('cover', $request->file('cover'));
    $book = $this->mainRepository->create([
      'title' => $request->title,
      'background' => $request->background,
      'cover' => $filePath
    ]);

    return $book;
  }

  public function findBookByBookId($id)
  {
    return $this->mainRepository->with(['bookCategory.category', 'bookPublisher.publisher'])->find($id);
  }

  public function destroyBookWithBookId($book)
  {
    if (Storage::disk('public')->exists($book->cover)) {
      Storage::disk('public')->delete($book->cover);
    }

    return $book->delete();
  }

  public function updateBookWithBookCategoryByBookId($request, $book)
  {
    $book->title = $request->title;
    $book->background = $request->background;

    if ($request->file('cover')) {
      if (Storage::disk('public')->exists($book->cover)) {
        Storage::disk('public')->delete($book->cover);
      }
      $filePath = Storage::disk('public')->putFile('cover', $request->file('cover'));
      $book->cover = $filePath;
    }

    return $book->save();
  }

  // Define your custom methods :)
}
