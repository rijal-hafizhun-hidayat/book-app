<?php

namespace App\Services\BookRecap;

use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\User;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\BookRecap\BookRecapRepository;

class BookRecapServiceImplement extends ServiceApi implements BookRecapService
{
  protected $categoryRepository;
  protected $publisherRepository;
  protected $userRepository;

  public function __construct(Category $categoryRepository, Publisher $publisherRepository, User $userRepository)
  {
    $this->categoryRepository = $categoryRepository;
    $this->publisherRepository = $publisherRepository;
    $this->userRepository = $userRepository;
  }

  public function getDataByCategory()
  {
    $queryCategory = $this->categoryRepository->with('bookCategory.book')->withCount('bookCategory');

    if (request()->filled('category_id')) {
      $queryCategory->where('id', request()->category_id);
    }

    return $queryCategory->get();
  }

  public function getDataByPublisher()
  {
    $queryPublisher = $this->publisherRepository->with('bookPublisher.book')->withCount('bookPublisher');

    if (request()->filled('publisher_id')) {
      $queryPublisher->where('id', request()->publisher_id);
    }

    return $queryPublisher->get();
  }

  public function getDataByWriter()
  {
    $queryUser = $this->userRepository->with('bookWriter.book')->withCount('bookWriter')->orderBy('book_writer_count', 'asc');

    if (request()->filled('user_id')) {
      $queryUser->where('id', request()->user_id);
    }

    return $queryUser->get();
  }

  // Define your custom methods :)
}
