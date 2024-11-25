<?php

namespace App\Services\Publisher;

use App\Models\Publisher;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\Publisher\PublisherRepository;

class PublisherServiceImplement extends ServiceApi implements PublisherService
{

  protected $mainRepository;

  public function __construct(Publisher $mainRepository)
  {
    $this->mainRepository = $mainRepository;
  }

  public function getAll()
  {
    return $this->mainRepository->all();
  }

  // Define your custom methods :)
}
