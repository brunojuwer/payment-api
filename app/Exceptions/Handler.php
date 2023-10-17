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
    }
}
