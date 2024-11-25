<?php

namespace App\Services\User;

use App\Models\User;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\User\UserRepository;

class UserServiceImplement extends ServiceApi implements UserService
{
  protected $mainRepository;

  public function __construct(User $mainRepository)
  {
    $this->mainRepository = $mainRepository;
  }

  public function getUserByRoleWriter()
  {
    return $this->mainRepository->whereHas('UserRole', function ($query) {
      $query->where('role_id', 2);
    })->get();
  }

  // Define your custom methods :)
}
