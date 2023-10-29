<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (AccountNotFoundException $e, $request) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Entity not found',
                    'detail' => $e->getMessage()
                ], 400);
        });

        $this->renderable(function (InsufficientBalanceException $e, $request) {
            return response()->json([
                'status' => 409,
                'message' => 'Business rule exception',
                'detail' => $e->getMessage()
            ], 409);
        });

        $this->renderable(function (ForbiddenUserAction $e, $request) {
            return response()->json([
                'status' => 403,
                'message' => 'Forbidden',
                'detail' => $e->getMessage()
            ], 403);
        });
    }
}
