<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
// Import the Log facade for debugging
use Illuminate\Support\Facades\Log;
// Import Exception classes for specific handling
use Illuminate\Database\QueryException;
use Exception;

// Use your application's base Controller class
use App\Http\Controllers\Controller;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch properties, eager load the owner relationship
        $properties = Property::with('owner')->paginate(10);

        // Return the HTML view for the web interface
        return view('properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the create view
        return view('properties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // --- Debugging: Log that the method was called ---
        Log::debug('PropertyController@store method called', ['user_id' => Auth::id()]);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255', // Assuming 'title' from form
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|string',
            'country' => 'required|string',
            'property_type' => 'required|string',
            'number_of_units' => 'required|integer|min:1', // Or bedrooms/bathrooms if that's the model
            // 'purchase_date' => 'nullable|date', // Uncomment if used
            // 'purchase_price' => 'nullable|numeric|min:0', // Uncomment if used
            'description' => 'nullable|string',
            'amenities' => 'nullable|array', // For checkboxes
            'amenities.*' => 'string|in:wifi,kitchen,parking,pool,ac,washer,tv',
            'images' => 'nullable|array', // For file uploads
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Validate each image
        ]);

        if ($validator->fails()) {
            // Differentiate response based on request type
            if ($request->expectsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // --- Main Logic with Error Handling ---
        try {
            // --- Debugging: Log incoming data ---
            Log::debug('Property Creation Request Data (After Validation):', [
                'validated_data' => $validator->validated(),
                'all_request_data' => $request->all(),
                'user_id' => Auth::id()
            ]);

            // Prepare data for creation
            // Use only specific, validated/expected fields from the request for security.
            $validatedData = $validator->validated();

            // Map form field name 'title' to database column 'name' if necessary
            $propertyData = [];
            foreach ($validatedData as $key => $value) {
                if ($key === 'title') {
                    $propertyData['name'] = $value;
                } else {
                    $propertyData[$key] = $value;
                }
            }

            // Add the owner_id
            $propertyData['owner_id'] = Auth::id();

            // --- Debugging: Log data being passed to create ---
            Log::debug('Property Data to be Created (Before Model Create):', $propertyData);

            // Create the property using the prepared data
            $property = Property::create($propertyData);

            // --- Debugging: Log success ---
            Log::info('Property created successfully in Controller', [
                'property_id' => $property->id,
                'property_name' => $property->name,
                'owner_id' => $property->owner_id
            ]);

            // --- Handle Images (Basic Example) ---
            // This part depends heavily on your specific image handling logic.
            // You might store images in storage/app/public and save paths,
            // or use a dedicated media library package.
            // The logic below is a simplified placeholder.
            /*
            if ($request->hasFile('images')) {
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    if ($image && $image->isValid()) {
                        // Store in storage/app/public/property_images
                        // 'public' disk stores in storage/app/public, accessible via /storage/...
                        $path = $image->store('property_images', 'public');
                        if ($path) {
                            $imagePaths[] = $path; // Store relative path
                            // Or store full URL: $imagePaths[] = Storage::disk('public')->url($path);
                        } else {
                             Log::warning('Failed to store an image for property', ['property_id' => $property->id, 'image_name' => $image->getClientOriginalName()]);
                        }
                    } else {
                        Log::warning('Invalid image file uploaded', ['property_id' => $property->id]);
                    }
                }
                if (!empty($imagePaths)) {
                    // Update the property's images column (JSON)
                    // Ensure your Property model casts 'images' to 'array'
                    $property->update(['images' => $imagePaths]);
                    Log::debug('Property images updated', ['property_id' => $property->id, 'image_paths' => $imagePaths]);
                }
            }
            */

            // Return response based on request type
            if ($request->expectsJson()) {
                // Eager load owner for the JSON response if needed
                // $property->load('owner');
                return response()->json($property, 201); // 201 Created
            }

            // Redirect for web requests
            return redirect()->route('properties.index')->with('success', 'Property created successfully!');

        } catch (QueryException $e) {
            // Specific handling for database query errors (e.g., constraint violations, data type issues)
            Log::error('Database Error Creating Property:', [
                'message' => $e->getMessage(),
                'sql' => $e->getSql(),
                'bindings' => $e->getBindings(),
                'user_id' => Auth::id(),
                'input_data' => $request->all() // Log input for context, be cautious with sensitive data
            ]);
            $errorMessage = 'A database error occurred while creating the property. Please check the data and try again.';

        } catch (Exception $e) {
            // General exception handling for any other unexpected errors
            Log::error('General Error Creating Property:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'input_data' => $request->all() // Log input for context
            ]);
            $errorMessage = 'An unexpected error occurred while creating the property. Please try again.';
        }

        // If we reach here, an exception was caught

        // Return error response based on request type
        if ($request->expectsJson()) {
            return response()->json(['error' => $errorMessage], 500); // 500 Internal Server Error
        }

        // Redirect back for web requests with error message and input data
        return redirect()->back()->withErrors(['error' => $errorMessage])->withInput();
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        $property->load(['owner', 'units']); // Eager load relationships
        // Differentiate response based on request type
        if (request()->expectsJson()) {
            return response()->json($property);
        }
        // Assuming you have a show view
        return view('properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        // Ensure only the owner can edit (basic check)
        // You might want more robust authorization (e.g., Policies)
        if (Auth::id() !== $property->owner_id) {
             if (request()->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            abort(403); // Or redirect with error
        }

        // Return the edit view
        return view('properties.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
         // Ensure only the owner can update (basic check)
        if (Auth::id() !== $property->owner_id) {
             if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            return redirect()->back()->withErrors(['error' => 'Unauthorized']);
        }

        // Define validation rules for update (might be slightly different than store)
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255', // Assuming 'title' from form
            'address' => 'sometimes|string',
            'city' => 'sometimes|string',
            'state' => 'sometimes|string',
            'zip_code' => 'sometimes|string',
            'country' => 'sometimes|string',
            'property_type' => 'sometimes|string',
            'number_of_units' => 'sometimes|integer|min:1',
            // 'purchase_date' => 'nullable|date',
            // 'purchase_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string|in:wifi,kitchen,parking,pool,ac,washer,tv',
            'images' => 'nullable|array', // For adding new images, maybe needs different handling
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Prepare data for update, mapping 'title' to 'name'
            $validatedData = $validator->validated();
            $updateData = [];
            foreach ($validatedData as $key => $value) {
                if ($key === 'title') {
                    $updateData['name'] = $value;
                } else {
                    $updateData[$key] = $value;
                }
            }

            // Perform the update
            $property->update($updateData);

            Log::info('Property updated successfully', ['property_id' => $property->id]);

            if ($request->expectsJson()) {
                // Reload relationships if needed
                // $property->load('owner', 'units');
                return response()->json($property);
            }
            return redirect()->route('properties.show', $property)->with('success', 'Property updated successfully');

        } catch (Exception $e) {
            Log::error('Error updating property', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'property_id' => $property->id,
                'user_id' => Auth::id()
            ]);
            $errorMessage = 'An error occurred while updating the property. Please try again.';

             if ($request->expectsJson()) {
                return response()->json(['error' => $errorMessage], 500);
            }
            return redirect()->back()->withErrors(['error' => $errorMessage])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
         // Ensure only the owner can delete (basic check)
        if (Auth::id() !== $property->owner_id) {
             if (request()->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            return redirect()->back()->withErrors(['error' => 'Unauthorized']);
        }

        try {
            $property->delete();
            Log::info('Property deleted successfully', ['property_id' => $property->id]);

            if (request()->expectsJson()) {
                return response()->json(['message' => 'Property deleted successfully']);
            }
            return redirect()->route('properties.index')->with('success', 'Property deleted successfully');

        } catch (Exception $e) {
            Log::error('Error deleting property', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'property_id' => $property->id,
                'user_id' => Auth::id()
            ]);
            $errorMessage = 'An error occurred while deleting the property. Please try again.';

            if (request()->expectsJson()) {
                return response()->json(['error' => $errorMessage], 500);
            }
            return redirect()->back()->withErrors(['error' => $errorMessage]);
        }
    }

    // Placeholder methods for the image routes (implement as needed)
    // These might need adjustment based on how you manage images (e.g., delete by image path/id)
    public function deleteImage($imageIdentifier) // $imageIdentifier could be ID, path, etc.
    {
        // Implement image deletion logic
        // Find property associated with the image, check ownership, delete file, update DB
        Log::warning('deleteImage method called but not implemented', ['image_id' => $imageIdentifier]);
        if (request()->expectsJson()) {
            return response()->json(['message' => 'Image deletion logic not implemented yet.'], 501); // 501 Not Implemented
        }
        return redirect()->back()->with('info', 'Image deletion logic not implemented yet.');
    }

    public function setMainImage($imageIdentifier)
    {
        // Implement set main image logic
        // Find property, check ownership, update 'main_image' field or reorder images array
        Log::warning('setMainImage method called but not implemented', ['image_id' => $imageIdentifier]);
        if (request()->expectsJson()) {
            return response()->json(['message' => 'Set main image logic not implemented yet.'], 501);
        }
        return redirect()->back()->with('info', 'Set main image logic not implemented yet.');
    }
}