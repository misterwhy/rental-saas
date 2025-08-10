<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Lease; // Make sure Lease model exists
use App\Models\Property; // Make sure Property model exists
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse; // Import for type hinting

class TenantController extends Controller
{
    /**
     * Display a listing of the tenants.
     * Primarily for landlords/admins.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // TODO: Add authorization check if only landlords should access this
        $tenants = Tenant::with('user')->paginate(10);
        return response()->json($tenants);
    }

    /**
     * Store a newly created tenant in storage.
     * Primarily for landlords/admins.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // TODO: Add authorization check
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id|unique:tenants,user_id', // Ensure user_id is unique in tenants table
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:tenants,email',
            'phone_number' => 'required|string|max:20',
            'date_of_birth' => 'nullable|date',
            // 'emergency_contact' => 'nullable|array', // Storing arrays directly might need $casts in the model
            'background_check_status' => 'nullable|string|in:Pending,Approved,Denied',
            'credit_score' => 'nullable|integer|min:0|max:850',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $tenant = Tenant::create($request->all());
        // Load the user relationship for the response
        $tenant->load('user');
        return response()->json($tenant, 201);
    }

    /**
     * Display the specified tenant.
     * Could be for admins/landlords or potentially the tenant themselves.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Tenant $tenant)
    {
        // TODO: Add authorization: allow admins, the tenant's user, or the landlord of properties they lease
        $tenant->load(['user', 'leases.property.owner', 'leases.property.images', 'payments']);
        return response()->json($tenant);
    }

    /**
     * Update the specified tenant in storage.
     * Primarily for landlords/admins or the tenant themselves.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tenant  $tenant
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Tenant $tenant)
    {
         // TODO: Add authorization check
        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|exists:users,id|unique:tenants,user_id,' . $tenant->id, // Allow updating user_id, but must be unique
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:tenants,email,' . $tenant->id,
            'phone_number' => 'sometimes|string|max:20',
            'date_of_birth' => 'nullable|date',
            // 'emergency_contact' => 'nullable|array',
            'background_check_status' => 'nullable|string|in:Pending,Approved,Denied',
            'credit_score' => 'nullable|integer|min:0|max:850',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $tenant->update($request->all());
        // Reload relationships if needed for the response
        $tenant->load(['user', 'leases.property.owner', 'leases.property.images']);
        return response()->json($tenant);
    }

    /**
     * Remove the specified tenant from storage.
     * Primarily for admins/landlords.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Tenant $tenant)
    {
        // TODO: Add authorization check
        // Consider implications: deleting a tenant should ideally handle associated leases/payments
        $tenant->delete();
        return response()->json(['message' => 'Tenant deleted successfully']);
    }

    /**
     * Display the property assigned to the authenticated tenant.
     * This is the new method for tenants to see their own property details.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showMyProperty(): JsonResponse
    {
        try {
            // 1. Get the currently authenticated User
            $user = Auth::user();

            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            // 2. Find the Tenant record associated with this User
            $tenant = Tenant::where('user_id', $user->id)->first();

            if (!$tenant) {
                // Handle case where user exists but no tenant profile found
                return response()->json(['error' => 'Tenant profile not found. Please contact your administrator.'], 404);
            }

            // 3. Load necessary relationships
            // Find the relevant lease. This example gets the first one.
            // You should implement logic to find the "active" or "current" lease.
            // E.g., maybe Lease has a status field or start/end dates.
            $tenant->load([
                'leases.property.owner',
                'leases.property.images'
            ]);

            // Get the first lease (or implement logic to find the "active" one)
            // Example: $lease = $tenant->leases()->where('status', 'active')->first();
            // Or based on dates: $lease = $tenant->leases()->where('start_date', '<=', now())->where('end_date', '>=', now())->first();
            $lease = $tenant->leases->firstWhere('status', 'active'); // Example assuming a status field

            // Fallback to first lease if no active one found
            if (!$lease) {
                 $lease = $tenant->leases->first();
            }

            if (!$lease || !$lease->property) {
                // Handle case where tenant exists but has no assigned property/lease
                return response()->json(['message' => 'You are not currently assigned to any property. Please contact your landlord.'], 200);
            }

            $property = $lease->property;

            // 4. Format the data to return
            $propertyData = [
                'id' => $property->id,
                'name' => $property->name,
                'slug' => $property->slug ?? null, // Include slug if it exists
                'address' => $property->address,
                'city' => $property->city,
                'state' => $property->state,
                'zip_code' => $property->zip_code,
                'country' => $property->country,
                'property_type' => $property->property_type,
                'number_of_units' => $property->number_of_units,
                'monthly_rent' => $property->purchase_price, // Assuming purchase_price holds rent
                'description' => $property->description,
                'amenities' => $property->amenities ?? [],
                'images' => $property->images->map(function($image) {
                    return [
                        'id' => $image->id,
                        'url' => $image->image_path ? asset('storage/' . $image->image_path) : null,
                        // Add other image attributes if needed
                    ];
                }),
                'landlord' => [
                    'id' => $property->owner->id,
                    'name' => $property->owner->name,
                    'email' => $property->owner->email,
                    // Add other landlord contact details if available and appropriate
                ],
                'lease' => [
                    'id' => $lease->id,
                    'start_date' => $lease->start_date,
                    'end_date' => $lease->end_date,
                    'rent_amount' => $lease->rent_amount,
                    'status' => $lease->status,
                    // Add other lease details if needed
                ]
            ];

            return response()->json($propertyData);

        } catch (\Exception $e) {
            // Log the error for debugging (ensure logging is configured)
            \Log::error('Error fetching tenant property: ' . $e->getMessage(), [
                'user_id' => Auth::id() ?? 'N/A',
                'tenant_id' => $tenant->id ?? 'N/A',
                'exception' => $e
            ]);
            return response()->json(['error' => 'An error occurred while fetching property information.'], 500);
        }
    }

    // You can add more tenant-specific methods here as needed
    // e.g., getRentHistory, submitMaintenanceRequest, etc.
}