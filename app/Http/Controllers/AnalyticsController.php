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
        $user = auth()->user();
        
        // Existing metrics
        $totalProperties = $user->properties->count();
        $totalUnits = $user->properties->sum('number_of_units');
        $totalPortfolioValue = $user->properties->sum('purchase_price');
        
        // New metrics
        $totalMonthlyIncome = $user->properties->sum(function ($property) {
            return $property->leases->where('status', 'active')->sum('monthly_rent');
        });
        
        // Existing chart data
        $valueByType = $user->properties()
            ->select('property_type', \DB::raw('SUM(purchase_price) as total_value'), \DB::raw('COUNT(*) as count'))
            ->groupBy('property_type')
            ->get();
        
        $valueByTypeLabels = $valueByType->pluck('property_type')->toArray();
        $valueByTypeData = $valueByType->pluck('total_value')->map(fn($value) => $value ?? 0)->toArray();
        
        $countByType = $user->properties()
            ->select('property_type', \DB::raw('COUNT(*) as count'))
            ->groupBy('property_type')
            ->get();
        
        $countByTypeLabels = $countByType->pluck('property_type')->toArray();
        $countByTypeData = $countByType->pluck('count')->toArray();
        
        $unitsByType = $user->properties()
            ->select('property_type', \DB::raw('SUM(number_of_units) as total_units'))
            ->groupBy('property_type')
            ->get();
        
        $unitsByTypeLabels = $unitsByType->pluck('property_type')->toArray();
        $unitsByTypeData = $unitsByType->pluck('total_units')->map(fn($value) => $value ?? 0)->toArray();
        
        // New profitability data
        $topProperties = $user->properties->sortByDesc(function ($property) {
            return $property->leases->where('status', 'active')->sum('monthly_rent');
        })->take(5);
        
        $topPropertiesLabels = $topProperties->pluck('name')->toArray();
        $topPropertiesData = $topProperties->map(function ($property) {
            return $property->leases->where('status', 'active')->sum('monthly_rent');
        })->toArray();
        
        // Properties with financial data
        $propertiesWithFinancials = $user->properties->map(function ($property) {
            $monthlyIncome = $property->leases->where('status', 'active')->sum('monthly_rent');
            $occupiedUnits = $property->leases->where('status', 'active')->count();
            $occupancyRate = $property->number_of_units > 0 ? 
                round(($occupiedUnits / $property->number_of_units) * 100) : null;
            
            return (object) [
                'name' => $property->name,
                'address' => $property->address,
                'property_type' => $property->property_type,
                'number_of_units' => $property->number_of_units,
                'purchase_price' => $property->purchase_price,
                'monthly_income' => $monthlyIncome,
                'occupancy_rate' => $occupancyRate
            ];
        });

        return view('analytics.index', compact(
            'totalProperties',
            'totalUnits',
            'totalPortfolioValue',
            'totalMonthlyIncome',
            'valueByTypeLabels',
            'valueByTypeData',
            'countByTypeLabels',
            'countByTypeData',
            'unitsByTypeLabels',
            'unitsByTypeData',
            'topPropertiesLabels',
            'topPropertiesData',
            'propertiesWithFinancials'
        ));
    }
}