<?php

namespace App\Services;

use App\Exceptions\ForbiddenUserAction;
use App\Models\User;
use Illuminate\Http\Request;

class AuthService 
{
  public static function checkUserAuthorization(User $user, Request $request)
  {
    $authenticatedUser = $request->user();
    if($user['id'] !== $authenticatedUser['id']) {
      throw new ForbiddenUserAction;
    }
  }
}