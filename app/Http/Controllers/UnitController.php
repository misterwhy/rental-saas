<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::with(['property'])->paginate(10);
        return response()->json($units);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'property_id' => 'required|exists:properties,id',
            'unit_number' => 'required|string|max:50',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'square_footage' => 'required|integer|min:0',
            'rent_amount' => 'required|numeric|min:0',
            'status' => 'required|string|in:Occupied,Vacant,Under Maintenance',
            'deposit_amount' => 'required|numeric|min:0',
            'available_date' => 'nullable|date',
            'images' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $unit = Unit::create($request->all());
        return response()->json($unit, 201);
    }

    public function show(Unit $unit)
    {
        $unit->load(['property', 'leases.currentLease']);
        return response()->json($unit);
    }

    public function update(Request $request, Unit $unit)
    {
        $validator = Validator::make($request->all(), [
            'property_id' => 'sometimes|exists:properties,id',
            'unit_number' => 'sometimes|string|max:50',
            'bedrooms' => 'sometimes|integer|min:0',
            'bathrooms' => 'sometimes|integer|min:0',
            'square_footage' => 'sometimes|integer|min:0',
            'rent_amount' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|string|in:Occupied,Vacant,Under Maintenance',
            'deposit_amount' => 'sometimes|numeric|min:0',
            'available_date' => 'nullable|date',
            'images' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $unit->update($request->all());
        return response()->json($unit);
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();
        return response()->json(['message' => 'Unit deleted successfully']);
    }

    public function byProperty(Property $property)
    {
        $units = Unit::where('property_id', $property->id)->with('currentLease')->paginate(10);
        return response()->json($units);
    }
}