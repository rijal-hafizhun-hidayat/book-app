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
    $queryBook =  $this->mainRepository->with(['bookCategory.category', 'bookPublisher.publisher', 'bookWriter.user']);
    if (request()->filled('author')) {
      $queryBook->whereHas('bookWriter', function ($query) {
        $query->whereIn('user_id', request()->author);
      });
    }

    if (request()->filled('category')) {
      $queryBook->whereHas('bookCategory', function ($query) {
        $query->whereIn('category_id', request()->category);
      });
    }

    if (request()->filled('publisher')) {
      $queryBook->whereHas('bookPublisher', function ($query) {
        $query->where('publisher_id', request()->publisher);
      });
    }

    if (request()->filled('title')) {
      $queryBook->where('title', 'like', '%' . request()->title . '%');
    }

    return $queryBook->get();
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
