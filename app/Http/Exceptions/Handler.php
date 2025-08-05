<?php
// app/Exceptions/Handler.php
namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }
            
            if ($exception instanceof \Illuminate\Validation\ValidationException) {
                return response()->json([
                    'error' => 'Validation failed',
                    'messages' => $exception->errors()
                ], 422);
            }
        }

        return parent::render($request, $exception);
    }
}