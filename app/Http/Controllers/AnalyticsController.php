<?php
// app/Http/Controllers/AnalyticsController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Property; // Make sure this points to your correct Property model
use Illuminate\Support\Facades\DB; // Add this for DB::raw

class AnalyticsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch user's properties with necessary relationships if needed later
        $properties = $user->properties; // Uses the relationship defined in User model

        // --- Calculate Analytics Data ---

        // 1. Property Value Distribution by Type (for Bar Chart)
        $propertyValueByType = $user->properties()
            ->select('property_type', DB::raw('SUM(purchase_price) as total_value'), DB::raw('COUNT(*) as count'))
            ->groupBy('property_type')
            ->get();
        $valueByTypeLabels = $propertyValueByType->pluck('property_type');
        $valueByTypeData = $propertyValueByType->pluck('total_value')->map(fn($v) => $v ?? 0);

        // 2. Property Count Distribution by Type (for Doughnut Chart)
        $propertyCountByType = $user->properties()
            ->select('property_type', DB::raw('COUNT(*) as count'))
            ->groupBy('property_type')
            ->get();
        $countByTypeLabels = $propertyCountByType->pluck('property_type');
        $countByTypeData = $propertyCountByType->pluck('count');

        // 3. Total Units Distribution by Type (Alternative for Bar Chart)
        $unitsByType = $user->properties()
            ->select('property_type', DB::raw('SUM(number_of_units) as total_units'))
            ->groupBy('property_type')
            ->get();
        $unitsByTypeLabels = $unitsByType->pluck('property_type');
        $unitsByTypeData = $unitsByType->pluck('total_units')->map(fn($u) => $u ?? 0);

        // 4. Summary Stats
        $totalProperties = $properties->count();
        $totalUnits = $properties->sum('number_of_units');
        $totalPortfolioValue = $properties->sum('purchase_price');

        // Pass data to the view
        return view('analytics.index', compact(
            'totalProperties',
            'totalUnits',
            'totalPortfolioValue',
            'valueByTypeLabels',
            'valueByTypeData',
            'countByTypeLabels',
            'countByTypeData',
            'unitsByTypeLabels',
            'unitsByTypeData'
            // Add more data points as needed for other charts/tables
        ));
    }
}