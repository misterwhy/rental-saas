<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Property;
use App\Models\MaintenanceRequest;
use App\Models\Lease;
use App\Models\RentPayment;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Redirect based on user type
        if ($user->role === 'landlord') {
            return $this->landlordDashboard();
        } elseif ($user->role === 'tenant') {
            return $this->tenantDashboard();
        }

        // Fallback: redirect to home if role is unknown
        return redirect()->route('home');
    }

    public function landlordDashboard()
    {
        $user = Auth::user();
        
        // Your existing landlord dashboard code
        $properties = $user->properties;
        $totalProperties = $properties->count();
        $totalUnits = $properties->sum('number_of_units');
        $totalPortfolioValue = $properties->sum('purchase_price');

        $propertyValueByType = $user->properties()
            ->select('property_type', DB::raw('SUM(purchase_price) as total_value'), DB::raw('COUNT(*) as count'))
            ->groupBy('property_type')
            ->get();

        $chartLabels = $propertyValueByType->pluck('property_type')->toArray();
        $chartValues = $propertyValueByType->pluck('total_value')->map(fn($value) => $value ?? 0)->toArray();
        $chartCounts = $propertyValueByType->pluck('count')->toArray();

        $propertyCountByType = $user->properties()
            ->select('property_type', DB::raw('COUNT(*) as count'))
            ->groupBy('property_type')
            ->get();

        $doughnutLabels = $propertyCountByType->pluck('property_type')->toArray();
        $doughnutValues = $propertyCountByType->pluck('count')->toArray();

        $totalMaintenanceRequests = MaintenanceRequest::whereIn('property_id', $user->properties->pluck('id'))->count();

        // Get notifications for landlord
        $notifications = $user->notifications()->latest()->limit(5)->get();
        $unreadNotificationsCount = $user->unreadNotifications()->count();

        return view('landlord.dashboard', compact(
            'totalProperties',
            'totalUnits',
            'totalPortfolioValue',
            'chartLabels',
            'chartValues',
            'chartCounts',
            'doughnutLabels',
            'doughnutValues',
            'totalMaintenanceRequests',
            'notifications',
            'unreadNotificationsCount'
        ));
    }

    public function tenantDashboard()
    {
        $user = Auth::user();
        
        // Get tenant's active lease
        $activeLease = Lease::where('tenant_id', $user->id)
            ->where('status', 'active')
            ->first();
        
        // Get upcoming payment
        $upcomingPayment = RentPayment::where('tenant_id', $user->id)
            ->where('status', 'pending')
            ->orderBy('due_date')
            ->first();
        
        // Get recent payments
        $recentPayments = RentPayment::where('tenant_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get maintenance requests
        $maintenanceRequests = MaintenanceRequest::where('tenant_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get notifications for tenant
        $notifications = $user->notifications()->latest()->limit(5)->get();
        $unreadNotificationsCount = $user->unreadNotifications()->count();

        // Pass tenant-specific data to the tenant dashboard view
        return view('tenant.dashboard', compact(
            'activeLease',
            'upcomingPayment',
            'recentPayments',
            'maintenanceRequests',
            'notifications',
            'unreadNotificationsCount'
        ));
    }
}