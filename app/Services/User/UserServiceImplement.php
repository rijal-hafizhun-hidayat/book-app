<?php

namespace App\Services\User;

use App\Models\User;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Auth;

class UserServiceImplement extends ServiceApi implements UserService
{
  protected $mainRepository;

  public function __construct(User $mainRepository)
  {
    $this->mainRepository = $mainRepository;
  }

  public function getUserByRoleWriter()
  {
    $user = Auth::user();
    $userQuery = $this->mainRepository->whereHas('UserRole', function ($query) {
      $query->where('role_id', 2);
    });

    if ($user->UserRole->role_id === 2) {
      $userQuery->where('id', $user->id);
    }

    return $userQuery->get();
  }

  // Define your custom methods :)
}
