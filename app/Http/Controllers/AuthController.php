<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = request(['email','password']);

        if(!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ],401);
        }

        $request->user()->tokens()->delete();
        $user = $request->user();
        $expirationDateTime = (new DateTime())->modify('+8 hours');
        $tokenResult = $user->createToken('Personal Access Token', ['*'], $expirationDateTime);
        $token = $tokenResult->plainTextToken;

        return response()->json([
            'accessToken' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
