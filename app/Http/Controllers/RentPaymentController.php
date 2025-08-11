<?php

namespace App\Http\Controllers;

use App\Models\RentPayment;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class RentPaymentController extends Controller
{
    /**
     * Display payment dashboard with search
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Initialize variables
        $totalReceived = 0;
        $totalPending = 0;
        $overdueCount = 0;
        $totalPaid = 0;
        
        // Search parameters
        $search = $request->get('search');
        $status = $request->get('status');
        $propertyId = $request->get('property_id');
        $month = $request->get('month');
        
        if ($user->isLandlord()) {
            // Build query for landlords
            $query = RentPayment::with(['property', 'tenant'])
                ->whereHas('property', function ($query) use ($user) {
                    $query->where('owner_id', $user->id);
                });
            
            // Apply search filters
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->whereHas('property', function($qp) use ($search) {
                        $qp->where('name', 'like', "%{$search}%");
                    })->orWhereHas('tenant', function($qt) use ($search) {
                        $qt->where('name', 'like', "%{$search}%");
                    });
                });
            }
            
            if ($status) {
                $query->where('status', $status);
            }
            
            if ($propertyId) {
                $query->where('property_id', $propertyId);
            }
            
            if ($month) {
                $query->whereMonth('due_date', date('m', strtotime($month)))
                      ->whereYear('due_date', date('Y', strtotime($month)));
            }
            
            $payments = $query->latest()->paginate(20)->appends($request->except('page'));
            
            // Get payment statistics for landlords
            $statsQuery = RentPayment::whereHas('property', function ($query) use ($user) {
                $query->where('owner_id', $user->id);
            });
            
            if ($search) {
                $statsQuery->where(function($q) use ($search) {
                    $q->whereHas('property', function($qp) use ($search) {
                        $qp->where('name', 'like', "%{$search}%");
                    })->orWhereHas('tenant', function($qt) use ($search) {
                        $qt->where('name', 'like', "%{$search}%");
                    });
                });
            }
            
            if ($status) {
                $statsQuery->where('status', $status);
            }
            
            if ($propertyId) {
                $statsQuery->where('property_id', $propertyId);
            }
            
            if ($month) {
                $statsQuery->whereMonth('due_date', date('m', strtotime($month)))
                          ->whereYear('due_date', date('Y', strtotime($month)));
            }
            
            $totalReceived = (clone $statsQuery)->where('status', 'paid')->sum('amount');
            $totalPending = (clone $statsQuery)->where('status', 'pending')->sum('amount');
            $overdueCount = (clone $statsQuery)->overdue()->count();
            
            // Get properties for filter dropdown
            $properties = Property::where('owner_id', $user->id)->get();
            
            return view('landlord.rent-payments.index', compact(
                'payments', 
                'totalReceived', 
                'totalPending', 
                'overdueCount', 
                'totalPaid',
                'properties',
                'search',
                'status',
                'propertyId',
                'month'
            ));
            
        } else {
            // Build query for tenants
            $query = RentPayment::with(['property'])
                ->whereHas('property', function ($query) use ($user) {
                    $query->where('tenant_id', $user->id);
                });
            
            // Apply search filters
            if ($search) {
                $query->whereHas('property', function($qp) use ($search) {
                    $qp->where('name', 'like', "%{$search}%");
                });
            }
            
            if ($status) {
                $query->where('status', $status);
            }
            
            if ($propertyId) {
                $query->where('property_id', $propertyId);
            }
            
            if ($month) {
                $query->whereMonth('due_date', date('m', strtotime($month)))
                      ->whereYear('due_date', date('Y', strtotime($month)));
            }
            
            $payments = $query->latest()->paginate(20)->appends($request->except('page'));
            
            // Get payment statistics for tenants
            $statsQuery = RentPayment::whereHas('property', function ($query) use ($user) {
                $query->where('tenant_id', $user->id);
            });
            
            if ($search) {
                $statsQuery->whereHas('property', function($qp) use ($search) {
                    $qp->where('name', 'like', "%{$search}%");
                });
            }
            
            if ($status) {
                $statsQuery->where('status', $status);
            }
            
            if ($propertyId) {
                $statsQuery->where('property_id', $propertyId);
            }
            
            if ($month) {
                $statsQuery->whereMonth('due_date', date('m', strtotime($month)))
                          ->whereYear('due_date', date('Y', strtotime($month)));
            }
            
            $totalPaid = (clone $statsQuery)->where('status', 'paid')->sum('amount');
            $totalPending = (clone $statsQuery)->where('status', 'pending')->sum('amount');
            $overdueCount = (clone $statsQuery)->overdue()->count();
            
            // Tenants don't need property filter dropdown
            $properties = collect();
            
            return view('tenant.payments.index', compact(
                'payments', 
                'totalReceived', 
                'totalPending', 
                'overdueCount', 
                'totalPaid',
                'properties',
                'search',
                'status',
                'propertyId',
                'month'
            ));
        }
    }

    /**
     * Show the form for creating a new rent payment
     */
    public function create()
    {
        $user = Auth::user();
        
        if (!$user->isLandlord()) {
            abort(403);
        }
        
        $properties = Property::where('owner_id', $user->id)->get();
        $tenants = User::where('role', 'tenant')->get();
        
        return view('landlord.rent-payments.create', compact('properties', 'tenants'));
    }

    /**
     * Store a newly created rent payment
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isLandlord()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'tenant_id' => 'required|exists:users,id',
            'due_date' => 'required|date',
            'payment_method' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);
        
        // Verify property belongs to user
        $property = Property::where('id', $request->property_id)
            ->where('owner_id', $user->id)
            ->firstOrFail();
        
        // Use purchase_price as the rent amount (or set a default)
        $amount = $property->purchase_price > 0 ? $property->purchase_price : 1000;
        
        $payment = RentPayment::create([
            'property_id' => $request->property_id,
            'tenant_id' => $request->tenant_id,
            'amount' => $amount,
            'due_date' => $request->due_date,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        // Redirect based on user role
        if ($user->isLandlord()) {
            return redirect()->route('landlord.rent-payments.index')->with('success', 'Rent payment created successfully!');
        } else {
            return redirect()->route('tenant.rent-payments.index')->with('success', 'Rent payment created successfully!');
        }
    }

    /**
     * Display the specified rent payment
     */
    public function show(RentPayment $rentPayment)
    {
        $user = Auth::user();
        
        // Check authorization
        if ($user->isLandlord()) {
            if ($rentPayment->property->owner_id !== $user->id) {
                abort(403);
            }
            return view('landlord.rent-payments.show', compact('rentPayment'));
        } else {
            if ($rentPayment->property->tenant_id !== $user->id) {
                abort(403);
            }
            return view('tenant.payments.show', compact('rentPayment'));
        }
    }

    /**
     * Show the form for editing the specified rent payment
     */
    public function edit(RentPayment $rentPayment)
    {
        $user = Auth::user();
        
        if (!$user->isLandlord()) {
            abort(403);
        }
        
        // Check authorization
        if ($rentPayment->property->owner_id !== $user->id) {
            abort(403);
        }
        
        $properties = Property::where('owner_id', $user->id)->get();
        $tenants = User::where('role', 'tenant')->get();
        
        return view('landlord.rent-payments.edit', compact('rentPayment', 'properties', 'tenants'));
    }

    /**
     * Update the specified rent payment
     */
    public function update(Request $request, RentPayment $rentPayment)
    {
        $user = Auth::user();
        
        if (!$user->isLandlord()) {
            abort(403);
        }
        
        // Check authorization
        if ($rentPayment->property->owner_id !== $user->id) {
            abort(403);
        }
        
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'tenant_id' => 'required|exists:users,id',
            'due_date' => 'required|date',
            'payment_method' => 'nullable|string|max:255',
            'status' => 'required|in:pending,paid,overdue',
            'notes' => 'nullable|string|max:1000',
        ]);
        
        // Verify property belongs to user
        $property = Property::where('id', $request->property_id)
            ->where('owner_id', $user->id)
            ->firstOrFail();
        
        // Use purchase_price as the rent amount (or set a default)
        $amount = $property->purchase_price > 0 ? $property->purchase_price : 1000;
        
        $rentPayment->update([
            'property_id' => $request->property_id,
            'tenant_id' => $request->tenant_id,
            'amount' => $amount,
            'due_date' => $request->due_date,
            'payment_method' => $request->payment_method,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        // Redirect based on user role
        if ($user->isLandlord()) {
            return redirect()->route('landlord.rent-payments.index')->with('success', 'Rent payment updated successfully!');
        } else {
            return redirect()->route('tenant.rent-payments.index')->with('success', 'Rent payment updated successfully!');
        }
    }

    /**
     * Remove the specified rent payment
     */
    public function destroy(RentPayment $rentPayment)
    {
        $user = Auth::user();
        
        if (!$user->isLandlord()) {
            abort(403);
        }
        
        // Check authorization
        if ($rentPayment->property->owner_id !== $user->id) {
            abort(403);
        }
        
        $rentPayment->delete();

        // Redirect based on user role
        if ($user->isLandlord()) {
            return redirect()->route('landlord.rent-payments.index')->with('success', 'Rent payment deleted successfully!');
        } else {
            return redirect()->route('tenant.rent-payments.index')->with('success', 'Rent payment deleted successfully!');
        }
    }

    /**
     * Mark payment as paid
     */
    public function markAsPaid(Request $request, RentPayment $rentPayment)
    {
        $user = Auth::user();
        
        // Allow both landlords and tenants to mark payments as paid
        if ($user->isLandlord()) {
            // Only property owner can mark payment as paid
            if ($rentPayment->property->owner_id !== $user->id) {
                abort(403);
            }
        } else {
            // Tenants can only mark their own payments as paid
            if ($rentPayment->tenant_id !== $user->id) {
                abort(403);
            }
        }

        $rentPayment->update([
            'status' => 'paid',
            'payment_date' => now(),
            'payment_method' => $request->payment_method ?? 'cash',
        ]);

        // Redirect based on user role
        if ($user->isLandlord()) {
            return redirect()->route('landlord.rent-payments.index')->with('success', 'Payment marked as paid successfully!');
        } else {
            return redirect()->route('tenant.rent-payments.index')->with('success', 'Payment marked as paid successfully!');
        }
    }

    
    /**
     * Generate monthly payments for properties
     */
    public function generateMonthlyPayments(Request $request)
    {
        $user = Auth::user();
        
        // Debug: Log the request
        \Log::info('Generate Monthly Payments Request', [
            'user_id' => $user->id,
            'user_type' => $user->role
        ]);
        
        // Get ALL properties owned by the current user (not just those with tenants)
        $properties = Property::where('owner_id', $user->id)->get();
        
        // Debug: Log properties found
        \Log::info('Properties found', [
            'count' => $properties->count(),
            'properties' => $properties->map(function($prop) {
                return [
                    'id' => $prop->id,
                    'name' => $prop->name,
                    'tenant_id' => $prop->tenant_id,
                    'purchase_price' => $prop->purchase_price
                ];
            })
        ]);
        
        $paymentsCreated = 0;
        
        foreach ($properties as $property) {
            // Debug: Log each property being processed
            \Log::info('Processing property', [
                'property_id' => $property->id,
                'property_name' => $property->name
            ]);
            
            // Check if payment already exists for this month
            $startOfMonth = now()->startOfMonth();
            $endOfMonth = now()->endOfMonth();
            
            $existingPayment = RentPayment::where('property_id', $property->id)
                ->whereBetween('due_date', [$startOfMonth, $endOfMonth])
                ->first();
            
            // Debug: Log existing payment check
            \Log::info('Existing payment check', [
                'property_id' => $property->id,
                'existing_payment' => $existingPayment ? $existingPayment->id : null
            ]);
                
            // Create payment for ALL properties (even without tenants for testing)
            if (!$existingPayment) {
                // Use the purchase_price as the monthly rent amount
                $monthlyRent = $property->purchase_price > 0 ? $property->purchase_price : 1000;
                
                // Debug: Log payment creation attempt
                \Log::info('Creating payment', [
                    'property_id' => $property->id,
                    'amount' => $monthlyRent,
                    'due_date' => now()->endOfMonth()
                ]);
                
                // Create payment for this month
                RentPayment::create([
                    'property_id' => $property->id,
                    'tenant_id' => $property->tenant_id ?? $user->id, // Use tenant_id if exists, otherwise user_id
                    'amount' => $monthlyRent,
                    'due_date' => now()->endOfMonth(),
                    'status' => 'pending',
                ]);
                $paymentsCreated++;
            }
        }

        $message = $paymentsCreated > 0 
            ? "{$paymentsCreated} monthly payments generated successfully!"
            : "No new payments generated. All properties already have payments for this month.";

        \Log::info('Generate payments completed', [
            'payments_created' => $paymentsCreated,
            'message' => $message
        ]);

        // Redirect based on user role
        if ($user->isLandlord()) {
            return redirect()->route('landlord.rent-payments.index')->with('success', $message);
        } else {
            return redirect()->route('tenant.rent-payments.index')->with('success', $message);
        }
    }

    /**
     * Get tenant for a property (AJAX)
     */
    public function getPropertyTenant($propertyId)
    {
        $user = Auth::user();
        
        $property = Property::where('id', $propertyId)
            ->where('owner_id', $user->id)
            ->first();
            
        if (!$property) {
            return response()->json(['error' => 'Property not found'], 404);
        }
        
        return response()->json([
            'tenant_id' => $property->tenant_id,
            'tenant_name' => $property->tenant ? $property->tenant->name : null
        ]);
    }

    public function downloadPDF(RentPayment $rentPayment)
    {
        $user = Auth::user();
        
        // Check authorization
        if ($user->isLandlord()) {
            if ($rentPayment->property->owner_id !== $user->id) {
                abort(403);
            }
            // Load the PDF view for landlord
            $pdf = PDF::loadView('landlord.rent-payments.pdf', compact('rentPayment'));
        } else {
            if ($rentPayment->property->tenant_id !== $user->id) {
                abort(403);
            }
            // For tenant, we might want to use the same PDF or create a tenant version
            // For now, using the same PDF view
            $pdf = PDF::loadView('landlord.rent-payments.pdf', compact('rentPayment'));
        }
        
        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');
        
        // Download the PDF
        return $pdf->download("payment-{$rentPayment->id}-receipt.pdf");
    }
}