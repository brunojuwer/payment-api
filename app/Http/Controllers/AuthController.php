<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct(
        protected AuthService $authService
    )
    {
        $this->authService = $authService;
    }


    public function login(Request $request): JsonResponse
    {
        $token = $this->authService->createToken($request);
        return response()->json([
            'accessToken' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}