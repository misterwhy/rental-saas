<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // --- Redirect Logic Based on User Type ---
            // Check if the user is a tenant using the user_type column
            if ($user->user_type === 'tenant') {
                // Redirect tenant to their property dashboard
                // Make sure the 'tenant.dashboard' route exists
                return redirect()->intended(route('tenant.dashboard', absolute: false));
            }

            // If not a tenant (assume landlord), redirect to landlord dashboard
            return redirect()->intended(route('dashboard', absolute: false));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validate all required fields, including user_type
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'], // Validate phone if provided
            'user_type' => ['required', 'string', 'in:landlord,tenant'], // Validate user_type
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Create the user, including user_type and phone (if provided)
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null, // Use null if phone is not provided
            'user_type' => $validated['user_type'], // Include user_type
            'password' => Hash::make($validated['password']),
        ]);

        // Log the user in automatically after registration
        Auth::login($user);

        // --- Redirect Logic After Registration ---
        // Check if the newly registered user is a tenant
        if ($user->user_type === 'tenant') {
             // Redirect tenant to their property dashboard
             // Make sure the 'tenant.dashboard' route exists
            return redirect()->route('tenant.dashboard');
        }

        // If not a tenant (assume landlord), redirect to landlord dashboard
        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the homepage after logout
        return redirect('/');
    }
}
