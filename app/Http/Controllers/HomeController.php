<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Booking;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Dashboard metrics
        $totalProperties = Property::count();
        $totalBookings = Booking::count();
        $totalRevenue = Booking::sum('total_amount') ?? 0;
        
        // Recent properties for display
        $featuredProperties = Property::where('is_active', true)
            ->with(['images', 'landlord'])
            ->latest()
            ->limit(6)
            ->get();

        // Recent transactions/bookings
        $recentTransactions = Booking::with(['property', 'tenant'])
            ->latest()
            ->limit(3)
            ->get();

        return view('home', compact(
            'featuredProperties', 
            'totalProperties', 
            'totalBookings', 
            'totalRevenue',
            'recentTransactions'
        ));
    }
}
