<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Exceptions\PropertyNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::where('is_active', true)->with('landlord');

        if ($request->filled('location')) {
            $query->where('city', 'LIKE', '%' . $request->location . '%');
        }

        if ($request->filled('min_price')) {
            $query->where('price_per_night', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price_per_night', '<=', $request->max_price);
        }

        if ($request->filled('guests')) {
            $query->where('max_guests', '>=', $request->guests);
        }

        $properties = $query->paginate(12);

        return view('properties.index', compact('properties'));
    }

    public function show(Property $property)
    {
        if (!$property->is_active) {
            abort(404);
        }

        $property->load(['images', 'reviews.user', 'landlord']);
        
        return view('properties.show', compact('property'));
    }

    public function create()
    {
        // Check if user is logged in
        if (!auth()->check()) {
            // If not logged in, redirect to login page
            return redirect()->route('login')->with('message', 'Please login to create a property.');
        }

        // Check if logged-in user is a landlord
        if (!auth()->user()->isLandlord()) {
            // If logged in but not a landlord, deny access (redirect home or show error)
            return redirect()->route('home')->with('error', 'Only landlords can create properties.');
        }

        // If user is logged in AND is a landlord, show the create form
        return view('properties.create');
    }

    public function store(StorePropertyRequest $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            $validated['landlord_id'] = auth()->id();

            $property = Property::create($validated);

            // Handle image uploads
            if ($request->hasFile('images')) {
                $this->handleImageUploads($request->file('images'), $property);
            }

            DB::commit();

            return redirect()->route('properties.show', $property)
                ->with('success', 'Property created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Property creation failed: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create property. Please try again.');
        }
    }

    /**
     * Handle multiple image uploads for a property
     */
    private function handleImageUploads(array $images, Property $property): void
    {
        foreach ($images as $index => $image) {
            $path = $image->store('property-images', 'public');
            
            PropertyImage::create([
                'property_id' => $property->id,
                'image_path' => $path,
                'is_main' => $index === 0, // First image is main by default
            ]);
        }
    }

    public function edit(Property $property)
    {
        // Manual authentication check
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->id() !== $property->landlord_id) {
            abort(403, 'You can only edit your own properties.');
        }

        $property->load('images'); // Load images for editing
        return view('properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        // Manual authentication check
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->id() !== $property->landlord_id) {
            abort(403, 'You can only edit your own properties.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'price_per_night' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'max_guests' => 'required|integer|min:1',
            'property_type' => 'required|string|max:50',
            'amenities' => 'array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
        ]);

        $validated['amenities'] = $request->amenities ?? [];
        $property->update($validated);

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('property_images', 'public');
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_path' => $path,
                    'is_main' => false, // New images are not main by default
                ]);
            }
        }

        return redirect()->route('properties.show', $property)
                        ->with('success', 'Property updated successfully!');
    }

    public function destroy(Property $property)
    {
        // Manual authentication check
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->id() !== $property->landlord_id) {
            abort(403, 'You can only delete your own properties.');
        }

        // Delete associated images
        foreach ($property->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $property->delete();

        return redirect()->route('dashboard')
                        ->with('success', 'Property deleted successfully!');
    }

    // Add method to delete individual images
    public function deleteImage(PropertyImage $image)
    {
        // Check if user owns the property
        if (!auth()->check() || auth()->id() !== $image->property->landlord_id) {
            abort(403, 'Unauthorized');
        }

        // Don't delete if it's the only image or main image with other images
        if ($image->property->images()->count() <= 1) {
            return redirect()->back()->with('error', 'Cannot delete the only image. Upload a new image first.');
        }

        if ($image->is_main) {
            return redirect()->back()->with('error', 'Cannot delete main image. Set another image as main first.');
        }

        // Delete the image file
        Storage::disk('public')->delete($image->image_path);

        // Delete the database record
        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully!');
    }

    // Add method to set main image
    public function setMainImage(PropertyImage $image)
    {
        // Check if user owns the property
        if (!auth()->check() || auth()->id() !== $image->property->landlord_id) {
            abort(403, 'Unauthorized');
        }

        // Remove main flag from all images of this property
        PropertyImage::where('property_id', $image->property_id)->update(['is_main' => false]);

        // Set this image as main
        $image->update(['is_main' => true]);

        return redirect()->back()->with('success', 'Main image updated successfully!');
    }
}