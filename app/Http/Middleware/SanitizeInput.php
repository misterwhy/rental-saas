<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeInput
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();
        
        array_walk_recursive($input, function (&$input) {
            if (is_string($input)) {
                // Remove any malicious scripts and trim whitespace
                $input = strip_tags(trim($input));
            }
        });
        
        $request->merge($input);
        
        return $next($request);
    }
}
