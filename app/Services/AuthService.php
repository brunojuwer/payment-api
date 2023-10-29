<?php

namespace App\Services;

use App\Exceptions\ForbiddenUserAction;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class AuthService 
{
  public static function checkUserAuthorization(User $user, Request $request)
  {
    $authenticatedUser = $request->user();
    if($user['id'] !== $authenticatedUser['id']) {
      throw new ForbiddenUserAction;
    }
  }

  public static function createToken(Request $request): string
  {
    self::validateCredentials($request);
    $request->user()->tokens()->delete();
    $user = $request->user();
    $expirationDateTime = (new DateTime())->modify('+8 hours');
    $tokenResult = $user->createToken('Personal Access Token', ['*'], $expirationDateTime);
    return $tokenResult->plainTextToken;
  }


  private static function validateCredentials(Request $request)
  {
    $request->validate([
      'email' => 'required|string|email',
      'password' => 'required|string',
    ]);

    $credentials = request(['email','password']);

    if(!Auth::attempt($credentials)) {
        throw new UnauthorizedException('Bad credentials');
    }
  }
}