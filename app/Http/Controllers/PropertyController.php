<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Add this line

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

    public function store(Request $request)
    {
        // Log the request
        Log::info('Property store request received', [
            'has_file' => $request->hasFile('image'),
            'all_inputs' => $request->all()
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        try {
            $property = new Property();
            $property->name = $request->name;
            $property->description = $request->description;
            $property->address = $request->address;
            $property->price = $request->price;

            // Handle image upload - using property_images directory
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                
                Log::info('Image file info', [
                    'is_valid' => $image->isValid(),
                    'original_name' => $image->getClientOriginalName(),
                    'size' => $image->getSize(),
                    'mime_type' => $image->getMimeType(),
                    'extension' => $image->getClientOriginalExtension()
                ]);
                
                if ($image->isValid()) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    
                    // Try to store the image
                    $path = $image->storeAs('public/property_images', $imageName);
                    
                    Log::info('Image storage result', [
                        'path' => $path,
                        'storage_path' => storage_path('app/public/property_images/' . $imageName)
                    ]);
                    
                    if ($path) {
                        $property->image = $imageName;
                        Log::info('Image stored successfully: ' . $imageName);
                    } else {
                        Log::error('Failed to store image: ' . $imageName);
                    }
                } else {
                    Log::error('Invalid image file uploaded');
                }
            }

            $property->save();
            Log::info('Property saved successfully', ['property_id' => $property->id]);

            return redirect()->route('properties.index')
                        ->with('success', 'Property created successfully');

        } catch (\Exception $e) {
            Log::error('Property creation error: ' . $e->getMessage(), [
                'exception' => $e,
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return redirect()->back()
                        ->with('error', 'Failed to create property: ' . $e->getMessage())
                        ->withInput();
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
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        try {
            $property->name = $request->name;
            $property->description = $request->description;
            $property->address = $request->address;
            $property->price = $request->price;

            // Handle image update
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                
                if ($image->isValid()) {
                    // Delete old image if exists
                    if ($property->image && Storage::exists('public/images/' . $property->image)) {
                        Storage::delete('public/images/' . $property->image);
                    }

                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $path = $image->storeAs('public/images', $imageName);
                    
                    if ($path) {
                        $property->image = $imageName;
                    }
                }
            }

            $property->save();

            return redirect()->route('properties.index')
                           ->with('success', 'Property updated successfully');

        } catch (\Exception $e) {
            Log::error('Property update error: ' . $e->getMessage());
            return redirect()->back()
                           ->with('error', 'Failed to update property. Please try again.')
                           ->withInput();
        }
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
