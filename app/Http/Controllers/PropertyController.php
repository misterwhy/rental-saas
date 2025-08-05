<?php
// app/Http/Controllers/PropertyController.php
namespace App\Http\Controllers;

use App\Models\Property;
use App\Http\Requests\PropertyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    // Remove the __construct method entirely

    public function index(Request $request)
    {
        try {
            $query = Property::with('user')->active();
            
            // Apply filters
            if ($request->filled('city')) {
                $query->inCity($request->city);
            }
            
            if ($request->filled('type')) {
                $query->byType($request->type);
            }
            
            if ($request->filled('min_price')) {
                $query->where('price', '>=', $request->min_price);
            }
            
            if ($request->filled('max_price')) {
                $query->where('price', '<=', $request->max_price);
            }
            
            if ($request->filled('bedrooms')) {
                $query->where('bedrooms', $request->bedrooms);
            }
            
            // Sorting
            $sortBy = $request->get('sort', 'created_at');
            $sortOrder = $request->get('order', 'desc');
            
            $properties = $query->orderBy($sortBy, $sortOrder)->paginate(12);
            
            return view('properties.index', compact('properties'));
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load properties.');
        }
    }

    public function create()
    {
        return view('properties.create');
    }

    public function store(PropertyRequest $request)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = auth()->id();
            
            // Handle image uploads
            if ($request->hasFile('images')) {
                $data['images'] = $this->uploadImages($request->file('images'));
            }
            
            $property = Property::create($data);
            
            return redirect()->route('properties.show', $property->slug)
                ->with('success', 'Property created successfully!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create property. Please try again.');
        }
    }

    public function show(Property $property)
    {
        $property->load(['user', 'reviews.user']);
        return view('properties.show', compact('property'));
    }

    public function edit(Property $property)
    {
        $this->authorize('update', $property);
        return view('properties.edit', compact('property'));
    }

    public function update(PropertyRequest $request, Property $property)
    {
        $this->authorize('update', $property);
        
        try {
            $data = $request->validated();
            
            // Handle image uploads
            if ($request->hasFile('images')) {
                // Delete old images if needed
                $this->deleteOldImages($property->images);
                $data['images'] = $this->uploadImages($request->file('images'));
            }
            
            $property->update($data);
            
            return redirect()->route('properties.show', $property->slug)
                ->with('success', 'Property updated successfully!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update property. Please try again.');
        }
    }

    public function destroy(Property $property)
    {
        $this->authorize('delete', $property);
        
        try {
            // Delete images
            $this->deleteOldImages($property->images);
            
            $property->delete();
            
            return redirect()->route('properties.index')
                ->with('success', 'Property deleted successfully!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete property. Please try again.');
        }
    }

    private function uploadImages($images)
    {
        $uploadedImages = [];
        
        foreach ($images as $image) {
            $filename = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('properties', $filename, 'public');
            $uploadedImages[] = $path;
        }
        
        return $uploadedImages;
    }

    private function deleteOldImages($images)
    {
        if ($images && is_array($images)) {
            foreach ($images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
    }
}