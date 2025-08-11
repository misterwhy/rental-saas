<?php

namespace App\Http\Controllers;

use App\Models\Lease;
use App\Models\Property;
use App\Models\RentPayment;
use App\Models\Image;
use App\Models\User;
use App\Models\Notification; // Add this import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PropertyController extends Controller
{
    /**
     * Display a listing of the properties.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        if ($user->isLandlord()) {
            $properties = Property::with('images', 'owner')
                ->where('owner_id', $user->id)
                ->paginate(12);
            return view('landlord.properties.index', compact('properties'));
        } else {
            // For tenants, show properties where they are the tenant
            $properties = Property::with('images', 'owner')
                ->where('tenant_id', $user->id)
                ->paginate(12);
            return view('tenant.properties.index', compact('properties'));
        }
    }

    /**
     * Show the form for creating a new property.
     */
    public function create()
    {
        $user = Auth::user();
        
        // Only landlords can create properties
        if (!$user->isLandlord()) {
            abort(403);
        }
        
        return view('landlord.properties.create');
    }

    /**
     * Store a newly created property in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Only landlords can create properties
        if (!$user->isLandlord()) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|string',
            'country' => 'required|string',
            'property_type' => 'required|in:Apartment,House,Condo,Townhouse,Cabin',
            'number_of_units' => 'required|integer|min:1',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string|in:wifi,kitchen,parking,pool,air_conditioning,washer,tv',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'tenant_email' => 'nullable|email|max:255|exists:users,email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $tenantId = null;
        $tenantEmail = $request->input('tenant_email');

        // Handle tenant assignment
        if ($tenantEmail) {
            $tenant = User::where('email', $tenantEmail)->first();

            if ($tenant) {
                // Ensure user has tenant role
                if ($tenant->role !== 'tenant') { // Changed from user_type to role
                    $tenant->update(['role' => 'tenant']);
                }
                $tenantId = $tenant->id;
            }
        }

        $property = Property::create([
            'name' => $request->title,
            'description' => $request->description,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'country' => $request->country,
            'property_type' => $request->property_type,
            'number_of_units' => $request->number_of_units,
            'purchase_date' => $request->purchase_date,
            'purchase_price' => $request->purchase_price,
            'amenities' => $request->amenities ?? [],
            'owner_id' => Auth::id(),
            'tenant_id' => $tenantId,
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store("properties/{$property->id}", 'public');
                $property->images()->create([
                    'image_path' => $path,
                    'is_main' => $property->images()->count() === 0,
                ]);
            }
        }

        // Create lease if tenant was assigned
        if ($tenantId) {
            $existingLease = Lease::where('property_id', $property->id)
                                  ->where('tenant_id', $tenantId)
                                  ->first();

            if (!$existingLease) {
                Lease::create([
                    'property_id' => $property->id,
                    'tenant_id' => $tenantId,
                    'start_date' => now(),
                    'end_date' => now()->addYear(),
                    'monthly_rent' => $property->purchase_price ?? 0,
                    'status' => 'active',
                ]);
            }
        }

        $successMessage = 'Property created successfully!';
        
        // Redirect based on user role
        if ($user->isLandlord()) {
            return redirect()->route('landlord.properties.show', $property)->with('success', $successMessage);
        } else {
            return redirect()->route('tenant.properties.show', $property)->with('success', $successMessage);
        }
    }

    /**
     * Display the specified property.
     */
    public function show(Property $property)
    {
        $user = Auth::user();
        
        // Check authorization based on user role
        if ($user->isLandlord()) {
            if ($property->owner_id !== $user->id) {
                abort(403);
            }
            $view = 'landlord.properties.show';
        } else {
            if ($property->tenant_id !== $user->id) {
                abort(403);
            }
            $view = 'tenant.properties.show';
        }

        $property->load('images', 'owner', 'tenant');
        
        $rentPayments = RentPayment::where('property_id', $property->id)
            ->with(['tenant'])
            ->latest()
            ->get();

        return view($view, compact('property', 'rentPayments'));
    }

    /**
     * Show the form for editing the specified property.
     */
    public function edit(Property $property)
    {
        $user = Auth::user();
        
        // Only landlords can edit properties
        if (!$user->isLandlord()) {
            abort(403);
        }
        
        // Check if user owns this property
        if ($property->owner_id !== $user->id) {
            abort(403);
        }

        $property->load('images', 'tenant');
        return view('landlord.properties.edit', compact('property'));
    }

    /**
     * Update the specified property in storage.
     */
    public function update(Request $request, Property $property)
    {
        $user = Auth::user();
        
        // Only landlords can update properties
        if (!$user->isLandlord()) {
            abort(403);
        }
        
        // Check if user owns this property
        if ($property->owner_id !== $user->id) {
            abort(403);
        }

        $validatorRules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|string',
            'country' => 'required|string',
            'property_type' => 'required|in:Apartment,House,Condo,Townhouse,Cabin',
            'number_of_units' => 'required|integer|min:1',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string|in:wifi,kitchen,parking,pool,air_conditioning,washer,tv',
            'new_images' => 'nullable|array|max:5',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'tenant_email' => 'nullable|email|max:255|exists:users,email',
        ];

        $validator = Validator::make($request->all(), $validatorRules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $tenantId = null;
        $tenantEmail = $request->input('tenant_email');

        // Handle tenant assignment
        if ($tenantEmail) {
            $tenant = User::where('email', $tenantEmail)->first();

            if ($tenant) {
                // Ensure user has tenant role
                if ($tenant->role !== 'tenant') { // Changed from user_type to role
                    $tenant->update(['role' => 'tenant']);
                }
                $tenantId = $tenant->id;
            }
        }

        // Update property details
        $property->update([
            'name' => $request->title,
            'description' => $request->description,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'country' => $request->country,
            'property_type' => $request->property_type,
            'number_of_units' => $request->number_of_units,
            'purchase_date' => $request->purchase_date,
            'purchase_price' => $request->purchase_price,
            'amenities' => $request->amenities ?? [],
            'tenant_id' => $tenantId,
        ]);

        // Create lease if tenant was assigned
        if ($tenantId) {
            $existingLease = Lease::where('property_id', $property->id)
                                  ->where('tenant_id', $tenantId)
                                  ->first();

            if (!$existingLease) {
                Lease::create([
                    'property_id' => $property->id,
                    'tenant_id' => $tenantId,
                    'start_date' => now(),
                    'end_date' => now()->addYear(),
                    'monthly_rent' => $property->purchase_price ?? 0,
                    'status' => 'active',
                ]);
            }
        }

        // Remove images that were marked for deletion
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $imageId) {
                $image = $property->images()->find($imageId);
                if ($image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }
        }

        // Handle new image uploads
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $file) {
                $path = $file->store("properties/{$property->id}", 'public');
                $property->images()->create([
                    'image_path' => $path,
                    'is_main' => $property->images()->count() === 0,
                ]);
            }
        }

        $successMessage = 'Property updated successfully!';

        // Redirect based on user role
        if ($user->isLandlord()) {
            return redirect()->route('landlord.properties.show', $property)->with('success', $successMessage);
        } else {
            return redirect()->route('tenant.properties.show', $property)->with('success', $successMessage);
        }
    }

    public function assignTenant(Request $request, Property $property)
    {
        $user = Auth::user();
        
        // Only landlords can assign tenants
        if (!$user->isLandlord()) {
            abort(403);
        }
        
        // Check if user owns this property
        if ($property->owner_id !== $user->id) {
            abort(403);
        }

        $request->validate([
            'tenant_email' => 'required|email|max:255|exists:users,email',
        ]);

        $tenant = User::where('email', $request->tenant_email)->first();

        if ($tenant->role !== 'tenant') {
            $tenant->update(['role' => 'tenant']);
        }

        $property->update(['tenant_id' => $tenant->id]);

        $existingLease = Lease::where('property_id', $property->id)
                            ->where('tenant_id', $tenant->id)
                            ->first();

        if (!$existingLease) {
            $lease = Lease::create([
                'property_id' => $property->id,
                'tenant_id' => $tenant->id,
                'start_date' => now(),
                'end_date' => now()->addYear(),
                'monthly_rent' => $property->purchase_price ?? 0,
                'status' => 'active',
            ]);
        }

        // Create notifications for both landlord and tenant
        Notification::create([
            'user_id' => $tenant->id,
            'title' => 'New Property Assignment',
            'message' => "You've been assigned to {$property->name}. Welcome to your new home!",
            'type' => 'info',
            'link' => route('tenant.properties.show', $property),
        ]);

        Notification::create([
            'user_id' => $property->owner_id,
            'title' => 'Tenant Assigned',
            'message' => "Tenant {$tenant->name} has been assigned to {$property->name}.",
            'type' => 'info',
            'link' => route('landlord.properties.show', $property),
        ]);

        return redirect()->route('landlord.properties.show', $property)
                        ->with('success', 'Tenant assigned successfully!');
    }

    public function showAssignTenantForm(Property $property)
    {
        $user = Auth::user();
        
        // Only landlords can assign tenants
        if (!$user->isLandlord()) {
            abort(403);
        }
        
        // Check if user owns this property
        if ($property->owner_id !== $user->id) {
            abort(403);
        }
        
        return view('landlord.properties.assign-tenant', compact('property'));
    }

    /**
     * Remove the specified property from storage.
     */
    public function destroy(Property $property)
    {
        $user = Auth::user();
        
        // Only landlords can delete properties
        if (!$user->isLandlord()) {
            abort(403);
        }
        
        // Check if user owns this property
        if ($property->owner_id !== $user->id) {
            abort(403);
        }

        $property->load('images');

        if ($property->images) {
            foreach ($property->images as $image) {
                if ($image->image_path) {
                    Storage::disk('public')->delete($image->image_path);
                }
            }
        }

        $property->delete();

        return redirect()->route('landlord.properties.index')->with('success', 'Property deleted successfully.');
    }

    /**
     * Set a specific image as the main image.
     */
    public function setMainImage($image)
    {
        $user = Auth::user();
        $image = Image::findOrFail($image);

        // Only landlords can manage property images
        if (!$user->isLandlord()) {
            abort(403);
        }
        
        // Check if user owns this property
        if ($image->property->owner_id !== $user->id) {
            abort(403);
        }

        $image->property->images()->update(['is_main' => false]);
        $image->is_main = true;
        $image->save();

        return back()->with('success', 'Main image updated.');
    }

    /**
     * Delete a specific image.
     */
    public function deleteImage($image)
    {
        $user = Auth::user();
        $image = Image::findOrFail($image);

        // Only landlords can manage property images
        if (!$user->isLandlord()) {
            abort(403);
        }
        
        // Check if user owns this property
        if ($image->property->owner_id !== $user->id) {
            abort(403);
        }

        if ($image->property->images()->count() <= 1) {
            return back()->withErrors(['error' => 'Cannot delete the only image. Upload a new one first.']);
        }

        if ($image->is_main) {
            $otherImage = $image->property->images()->where('id', '!=', $image->id)->first();
            if ($otherImage) {
                $otherImage->is_main = true;
                $otherImage->save();
            }
        }

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Image deleted.');
    }
}