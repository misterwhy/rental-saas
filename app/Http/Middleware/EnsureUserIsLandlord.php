<?php
// app/Http/Middleware/EnsureUserIsLandlord.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsLandlord
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->isLandlord() && !auth()->user()->isAdmin()) {
            return redirect()->back()->with('error', 'Access denied.');
        }

        return $next($request);
    }
}