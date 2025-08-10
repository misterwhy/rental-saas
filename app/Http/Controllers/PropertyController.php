<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\RentPayment;
use App\Models\Image;
use App\Models\User; // Import User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash; // Import Hash facade
use Illuminate\Support\Facades\Log; // Optional: For logging

class PropertyController extends Controller
{
    /**
     * Display a listing of the properties.
     */
    public function index(Request $request)
    {
        $properties = Property::with('images', 'owner')
            ->where('owner_id', Auth::id()) // Only show user's own properties
            ->paginate(12);
        return view('properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new property.
     */
    public function create()
    {
        // No need to pass potential tenants as they will be created on the fly
        return view('properties.create');
    }

    /**
     * Store a newly created property in storage.
     */
    public function store(Request $request)
    {
        // Add tenant_name and tenant_email validation
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
            'purchase_price' => 'nullable|numeric|min:0', // This will be the monthly rent
            'amenities' => 'nullable|array',
            'amenities.*' => 'string|in:wifi,kitchen,parking,pool,air_conditioning,washer,tv',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            // Tenant fields - make email required if name is provided, and vice versa
            'tenant_name' => 'nullable|string|max:255',
            'tenant_email' => 'nullable|email|max:255|unique:users,email', // Ensure email uniqueness in users table
            // Add a custom rule to require both or neither
             // We'll handle this logic in the controller after validation
        ]);

        // Custom validation after initial validation
        $validator->after(function ($validator) use ($request) {
             $name = $request->input('tenant_name');
             $email = $request->input('tenant_email');

             // If one is provided, the other must be too
             if (($name && !$email) || (!$name && $email)) {
                 $validator->errors()->add('tenant_name', 'Tenant name and email must both be provided or both be empty.');
                 $validator->errors()->add('tenant_email', 'Tenant name and email must both be provided or both be empty.');
             }
         });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $tenantId = null;
        $tenantName = $request->input('tenant_name');
        $tenantEmail = $request->input('tenant_email');

        // Handle tenant creation/linking
        if ($tenantName && $tenantEmail) {
            // Check if user already exists with that email
            $existingTenant = User::where('email', $tenantEmail)->first();

            if ($existingTenant) {
                // If user exists, check if they are a tenant
                if ($existingTenant->user_type !== 'tenant') {
                     return redirect()->back()->withErrors(['tenant_email' => 'A user with this email exists but is not a tenant.'])->withInput();
                }
                $tenantId = $existingTenant->id;
                // Optionally, update the name if it's different?
                // $existingTenant->update(['name' => $tenantName]);
            } else {
                // Create new tenant user with standard password
                $standardPassword = 'test2025'; // Standard password
                $tenantUser = User::create([
                    'name' => $tenantName,
                    'email' => $tenantEmail,
                    'password' => Hash::make($standardPassword), // Hash the standard password
                    'user_type' => 'tenant', // Assuming you have a user_type column
                    // Add other default fields as needed
                ]);
                $tenantId = $tenantUser->id;

                // TODO: Send notification email to tenant about their account and the standard password
                // Mail::to($tenantEmail)->send(new TenantNotification($tenantUser, $standardPassword));
                // Flash a message indicating the tenant account was created (less secure way to inform landlord)
                // Consider removing this in production and relying solely on email notification.
                // session()->flash('tenant_created_info', "Tenant account created for {$tenantEmail} with standard password 'test2025'. Please inform the tenant.");
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
            'purchase_price' => $request->purchase_price, // This is the monthly rent
            'amenities' => $request->amenities ?? [],
            'owner_id' => Auth::id(),
            'tenant_id' => $tenantId, // Assign the tenant ID (could be null)
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

        // Flash message about tenant creation if applicable
        $successMessage = 'Property created successfully!';
        if (session()->has('tenant_created_info')) {
            $successMessage .= ' ' . session('tenant_created_info');
        }

        return redirect()->route('properties.show', $property)->with('success', $successMessage);
    }

    /**
     * Display the specified property.
     */
    public function show(Property $property)
    {
        // PRIVACY CHECK: Only owner can view property
        if ($property->owner_id !== Auth::id()) {
            abort(403);
        }

        $property->load('images', 'owner', 'tenant'); // Load tenant relationship

        // Get rent payments for this property
        $rentPayments = RentPayment::where('property_id', $property->id)
            ->with(['tenant'])
            ->latest()
            ->get();

        return view('properties.show', compact('property', 'rentPayments'));
    }

    /**
     * Show the form for editing the specified property.
     */
    public function edit(Property $property)
    {
        // PRIVACY CHECK: Only owner can edit property
        if (Auth::id() !== $property->owner_id) {
            abort(403);
        }

        $property->load('images', 'tenant'); // Load tenant for pre-filling
        return view('properties.edit', compact('property'));
    }

    /**
     * Update the specified property in storage.
     */
    public function update(Request $request, Property $property)
    {
        // PRIVACY CHECK: Only owner can update property
        if (Auth::id() !== $property->owner_id) {
            abort(403);
        }

         // Add tenant_name and tenant_email validation (allowing existing tenant's email)
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
            'purchase_price' => 'nullable|numeric|min:0', // This is the monthly rent
            'amenities' => 'nullable|array',
            'amenities.*' => 'string|in:wifi,kitchen,parking,pool,air_conditioning,washer,tv',
            'new_images' => 'nullable|array|max:5',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            // Tenant fields
            'tenant_name' => 'nullable|string|max:255',
            'tenant_email' => 'nullable|email|max:255', // We'll check uniqueness separately
        ];

        // Custom validation after initial validation
        $validator = Validator::make($request->all(), $validatorRules);
        $validator->after(function ($validator) use ($request, $property) {
             $name = $request->input('tenant_name');
             $email = $request->input('tenant_email');

             // If one is provided, the other must be too
             if (($name && !$email) || (!$name && $email)) {
                 $validator->errors()->add('tenant_name', 'Tenant name and email must both be provided or both be empty.');
                 $validator->errors()->add('tenant_email', 'Tenant name and email must both be provided or both be empty.');
             }

             // If email is provided and it's different from the current tenant's email (if any), check uniqueness
             if ($email && (!$property->tenant || $email !== $property->tenant->email)) {
                 $existingUser = User::where('email', $email)->first();
                 if ($existingUser) {
                     $validator->errors()->add('tenant_email', 'This email is already associated with another user.');
                 }
             }
         });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $tenantId = null;
        $tenantName = $request->input('tenant_name');
        $tenantEmail = $request->input('tenant_email');

        // Handle tenant creation/linking/update
        if ($tenantName && $tenantEmail) {
            // Check if property already has this tenant assigned
            if ($property->tenant && $property->tenant->email === $tenantEmail) {
                // Tenant is already assigned, keep the same ID
                $tenantId = $property->tenant_id;
                 // Optionally update name if changed?
                 // if ($property->tenant->name !== $tenantName) {
                 //    $property->tenant->update(['name' => $tenantName]);
                 // }
            } else {
                // Need to assign a new tenant or create one
                 // Check if user already exists with that email (and is a tenant)
                $existingTenant = User::where('email', $tenantEmail)->first();

                if ($existingTenant) {
                    // If user exists, check if they are a tenant
                    if ($existingTenant->user_type !== 'tenant') {
                         return redirect()->back()->withErrors(['tenant_email' => 'A user with this email exists but is not a tenant.'])->withInput();
                    }
                    $tenantId = $existingTenant->id;
                } else {
                    // Create new tenant user with standard password
                    $standardPassword = 'test2025'; // Standard password
                    $tenantUser = User::create([
                        'name' => $tenantName,
                        'email' => $tenantEmail,
                        'password' => Hash::make($standardPassword), // Hash the standard password
                        'user_type' => 'tenant',
                        // Add other default fields as needed
                    ]);
                    $tenantId = $tenantUser->id;

                    // TODO: Send notification email to tenant about their account and the standard password
                    // Mail::to($tenantEmail)->send(new TenantNotification($tenantUser, $standardPassword));
                    // Flash a message indicating the tenant account was created (less secure way to inform landlord)
                    // Consider removing this in production and relying solely on email notification.
                    // session()->flash('tenant_created_info', "Tenant account created for {$tenantEmail} with standard password 'test2025'. Please inform the tenant.");
                }
            }
        }
        // If name/email are empty, tenant_id will be set to null, effectively unassigning


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
            'purchase_price' => $request->purchase_price, // This is the monthly rent
            'amenities' => $request->amenities ?? [],
            'tenant_id' => $tenantId, // Update the tenant ID (can be null to unassign)
        ]);

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

        // Flash message about tenant creation if applicable
        $successMessage = 'Property updated successfully!';
        if (session()->has('tenant_created_info')) {
           $successMessage .= ' ' . session('tenant_created_info');
           // Clear the flash message so it doesn't persist
           session()->forget('tenant_created_info');
        }

        return redirect()->route('properties.show', $property)->with('success', $successMessage);
    }

    /**
     * Remove the specified property from storage.
     */
    public function destroy(Property $property)
    {
        // PRIVACY CHECK: Only owner can delete property
        if (Auth::id() !== $property->owner_id) {
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

        return redirect()->route('properties.index')->with('success', 'Property deleted successfully.');
    }

    /**
     * Set a specific image as the main image.
     */
    public function setMainImage($image)
    {
        $image = \App\Models\Image::findOrFail($image);

        if (Auth::id() !== $image->property->owner_id) {
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
        $image = \App\Models\Image::findOrFail($image);

        if (Auth::id() !== $image->property->owner_id) {
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