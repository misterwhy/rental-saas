<?php

namespace App\Exceptions;

use Exception;

class PropertyNotFoundException extends Exception
{
    public function __construct(string $message = "Property not found or not available", int $code = 404)
    {
        parent::__construct($message, $code);
    }

    public function render($request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $this->getMessage()
            ], $this->getCode());
        }

        return response()->view('errors.404', [], 404);
    }
}
