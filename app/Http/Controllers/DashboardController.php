<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Property; // Ensure this is the correct path to your Property model
use App\Models\MaintenanceRequest; // Ensure this is the correct path

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // --- Fetch User's Properties ---
        // Eager load relationships if needed for other parts of the view
        $properties = $user->properties; // This uses the relationship defined in your User model

        // --- Calculate Real Dashboard Metrics ---
        $totalProperties = $properties->count();
        $totalUnits = $properties->sum('number_of_units');
        // Assuming a realistic total value calculation, perhaps total purchase price or a derived value
        // For now, let's use the sum of purchase prices as an example "value" metric.
        $totalPortfolioValue = $properties->sum('purchase_price'); // Handles nulls as 0

        // --- Calculate Data for the Bar Chart (Property Value by Type) ---
        // Group properties by type, sum their purchase prices, and prepare data for the chart
        $propertyValueByType = $user->properties()
            ->select('property_type', \DB::raw('SUM(purchase_price) as total_value'), \DB::raw('COUNT(*) as count'))
            ->groupBy('property_type')
            ->get();

        $chartLabels = $propertyValueByType->pluck('property_type')->toArray();
        // Format values for display (e.g., in thousands) if needed, or pass raw values
        // Chart.js can handle formatting in the tooltip callback.
        $chartValues = $propertyValueByType->pluck('total_value')->map(fn($value) => $value ?? 0)->toArray();
        // Optional: Pass counts if needed for tooltips or other logic
        $chartCounts = $propertyValueByType->pluck('count')->toArray();

        // --- Calculate Data for the Doughnut Chart (Property Count by Type) ---
        $propertyCountByType = $user->properties()
            ->select('property_type', \DB::raw('COUNT(*) as count'))
            ->groupBy('property_type')
            ->get();

        $doughnutLabels = $propertyCountByType->pluck('property_type')->toArray();
        $doughnutValues = $propertyCountByType->pluck('count')->toArray();

        // --- Calculate Maintenance Requests Count ---
        // Adjust this query based on your MaintenanceRequest model structure
        // E.g., if it belongsTo Property, and Property belongsTo User (owner)
        $totalMaintenanceRequests = MaintenanceRequest::whereIn('property_id', $user->properties->pluck('id'))->count();
        // Or, if requests are directly linked to the user in some way:
        // $totalMaintenanceRequests = $user->maintenanceRequests()->count(); // If you have this relationship

        // Pass all calculated data to the view
        return view('dashboard.landlord', compact(
            'totalProperties',
            'totalUnits',
            'totalPortfolioValue',
            'chartLabels',
            'chartValues',
            'chartCounts', // Optional
            'doughnutLabels',
            'doughnutValues',
            'totalMaintenanceRequests'
            // Add other data needed for "Recent Properties" or "Last Transactions" sections if updated
        ));
    }
}