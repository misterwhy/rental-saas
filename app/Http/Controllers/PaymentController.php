<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::with('owner')->paginate(10);
        return view('properties.index', compact('properties'));
    }

    public function create()
    {
        return view('properties.create');
    }

    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|string',
            'country' => 'required|string',
            'property_type' => 'required|string',
            'number_of_units' => 'required|integer|min:1',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'amenities' => 'nullable|array',
            'images' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $property = Property::create(array_merge(
            $request->all(),
            ['owner_id' => Auth::id()]
        ));

        return redirect()->route('properties.index')->with('success', 'Property created successfully');
    }

    public function show(Property $property)
    {
        $property->load(['owner', 'units']);
        return view('properties.show', compact('property'));
    }

    public function edit(Property $property)
    {
        return view('properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'address' => 'sometimes|string',
            'city' => 'sometimes|string',
            'state' => 'sometimes|string',
            'zip_code' => 'sometimes|string',
            'country' => 'sometimes|string',
            'property_type' => 'sometimes|string',
            'number_of_units' => 'sometimes|integer|min:1',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'amenities' => 'nullable|array',
            'images' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $property->update($request->all());
        return redirect()->route('properties.show', $property)->with('success', 'Property updated successfully');
    }

    public function destroy(Property $property)
    {
        $property->delete();
        return redirect()->route('properties.index')->with('success', 'Property deleted successfully');
    }

    public function deleteImage($image)
    {
        // Implement image deletion logic
        return redirect()->back()->with('success', 'Image deleted successfully');
    }

    public function setMainImage($image)
    {
        // Implement set main image logic
        return redirect()->back()->with('success', 'Main image updated successfully');
    }
}