<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Import any models you need to fetch data, for example:
// use App\Models\Booking; // Or whatever your booking model is named

class DashboardController extends Controller
{
    /**
     * Show the dashboard based on the user's type.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Check if the user object exists (should always be true if authenticated)
        if ($user) {
            // Check the user_type field
            if ($user->user_type === 'tenant') {
                // Prepare data needed for the tenant dashboard
                // You need to replace 'Booking' with your actual model name
                // and adjust the query logic based on your application's structure.
                // Example (replace with your actual logic):
                /*
                $bookings = Booking::where('tenant_id', $user->id)->get(); // Or however you link bookings to tenants
                $totalSpent = $bookings->sum('amount'); // Example calculation
                */

                // For now, let's pass empty/default data to avoid the error.
                // You MUST replace this with actual data retrieval logic.
                $bookings = collect(); // An empty collection
                $totalSpent = 0;

                // Pass the required variables to the view
                return view('dashboard.tenant', compact('bookings', 'totalSpent'));
            } else {
                // Default to the landlord dashboard for 'landlord' or any other/unknown type
                // If your landlord dashboard also needs specific data, pass it here too.
                return view('dashboard.landlord');
                // Example: return view('dashboard.landlord', compact('properties', 'tenants'));
            }
        }

        // This part should rarely be reached if the route is protected by 'auth' middleware
        // But it's good practice to handle unexpected states
        return redirect()->route('login');
    }
}