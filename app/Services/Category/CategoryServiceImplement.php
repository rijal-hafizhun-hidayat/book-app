<?php

namespace App\Services\Category;

use App\Models\Category;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\Category\CategoryRepository;

class CategoryServiceImplement extends ServiceApi implements CategoryService
{

  protected $mainRepository;

  public function __construct(Category $mainRepository)
  {
    $this->mainRepository = $mainRepository;
  }

  public function getAll()
  {
    return $this->mainRepository->all();
  }

  // Define your custom methods :)
}
