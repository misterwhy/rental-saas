<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserRole
{
    public function handle(Request $request, Closure $next, $role = null)
    {
        // If no role is specified, continue normally
        if ($role === null) {
            return $next($request);
        }

        if (!auth()->check()) {
            return redirect('login');
        }

        $user = auth()->user();
        
        // Use user_type instead of role
        if ($user->user_type !== $role) {
            // Redirect to appropriate dashboard
            if ($user->user_type === 'landlord') {
                return redirect('/landlord/dashboard');
            } elseif ($user->user_type === 'tenant') {
                return redirect('/tenant/dashboard');
            }
            
            // Fallback redirect
            return redirect('/dashboard');
        }

        return $next($request);
    }
}