<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
        return view('properties.create');
    }

    /**
     * Store a newly created property in storage.
     */
    public function store(Request $request)
    {
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
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

        return redirect()->route('properties.show', $property)->with('success', 'Property created successfully!');
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
        
        $property->load('images', 'owner');
        return view('properties.show', compact('property'));
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

        $property->load('images');
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
            'new_images' => 'nullable|array|max:5',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
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
        ]);

        // Remove images that were marked for deletion
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $imageId) {
                $image = $property->images()->find($imageId);
                if ($image) {
                    // Delete the file from storage
                    Storage::disk('public')->delete($image->image_path);
                    // Delete the database record
                    $image->delete();
                }
            }
        }

        // Handle new image uploads
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $file) {
                $path = $file->store("properties/{$property->id}", 'public');
                
                // Create image record
                $property->images()->create([
                    'image_path' => $path,
                    'is_main' => $property->images()->count() === 0,
                ]);
            }
        }

        return redirect()->route('properties.show', $property)->with('success', 'Property updated successfully!');
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

        // Load images relationship to ensure it's not null
        $property->load('images');
        
        // Delete all images from storage
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

        // PRIVACY CHECK: Only owner can set main image
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

        // PRIVACY CHECK: Only owner can delete image
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