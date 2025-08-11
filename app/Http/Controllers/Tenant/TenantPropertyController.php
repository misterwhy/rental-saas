<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\RentPayment;
use App\Models\Lease;

class TenantPropertyController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Try to get properties through leases first (preferred method)
        $properties = Property::whereHas('leases', function($query) use ($user) {
            $query->where('tenant_id', $user->id)
                  ->where('status', 'active');
        })->with('leases', 'owner')->paginate(10);

        // If no properties found through leases, fallback to rent payments
        if ($properties->count() == 0) {
            $properties = Property::whereHas('rentPayments', function($query) use ($user) {
                $query->where('tenant_id', $user->id);
            })->with('rentPayments')->paginate(10);
        }

        return view('tenant.properties.index', compact('properties'));
    }

    public function show($id)
    {
        $user = auth()->user();
        
        // Try to get property through leases first (preferred method)
        $property = Property::whereHas('leases', function($query) use ($user, $id) {
            $query->where('tenant_id', $user->id)
                  ->where('property_id', $id)
                  ->where('status', 'active');
        })->with('leases', 'owner')->find($id);

        // If not found through leases, fallback to rent payments
        if (!$property) {
            $property = Property::whereHas('rentPayments', function($query) use ($user, $id) {
                $query->where('tenant_id', $user->id)
                      ->where('property_id', $id);
            })->with('rentPayments')->findOrFail($id);
        }

        // If still not found, throw 404
        if (!$property) {
            abort(404);
        }

        return view('tenant.properties.show', compact('property'));
    }
}