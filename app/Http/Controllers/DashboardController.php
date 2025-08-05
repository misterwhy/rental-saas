<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Booking;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isLandlord()) {
            $properties = Property::where('landlord_id', $user->id)
                                ->withCount('bookings')
                                ->latest()
                                ->paginate(10);

            $recentBookings = Booking::whereHas('property', function ($query) use ($user) {
                                    $query->where('landlord_id', $user->id);
                                })
                                ->with(['property', 'tenant'])
                                ->latest()
                                ->limit(10)
                                ->get();

            return view('dashboard.landlord', compact('properties', 'recentBookings'));
        } else {
            $bookings = Booking::where('tenant_id', $user->id)
                              ->with('property')
                              ->latest()
                              ->paginate(10);

            return view('dashboard.tenant', compact('bookings'));
        }
    }
}