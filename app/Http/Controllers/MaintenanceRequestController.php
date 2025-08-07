<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MaintenanceRequestController extends Controller
{
    public function index()
    {
        $requests = MaintenanceRequest::with(['unit.property', 'tenant', 'assignedTo'])->paginate(10);
        return response()->json($requests);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unit_id' => 'required|exists:units,id',
            'tenant_id' => 'nullable|exists:tenants,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|string|in:Low,Medium,High',
            'status' => 'required|string|in:Open,In Progress,Completed,Cancelled',
            'assigned_to' => 'nullable|exists:users,id',
            'images' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $requestModel = MaintenanceRequest::create($request->all());
        return response()->json($requestModel, 201);
    }

    public function show(MaintenanceRequest $maintenanceRequest)
    {
        $maintenanceRequest->load(['unit.property', 'tenant', 'assignedTo']);
        return response()->json($maintenanceRequest);
    }

    public function update(Request $request, MaintenanceRequest $maintenanceRequest)
    {
        $validator = Validator::make($request->all(), [
            'unit_id' => 'sometimes|exists:units,id',
            'tenant_id' => 'nullable|exists:tenants,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'priority' => 'sometimes|string|in:Low,Medium,High',
            'status' => 'sometimes|string|in:Open,In Progress,Completed,Cancelled',
            'assigned_to' => 'nullable|exists:users,id',
            'images' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $maintenanceRequest->update($request->all());
        return response()->json($maintenanceRequest);
    }

    public function destroy(MaintenanceRequest $maintenanceRequest)
    {
        $maintenanceRequest->delete();
        return response()->json(['message' => 'Maintenance request deleted successfully']);
    }

    public function open()
    {
        $requests = MaintenanceRequest::open()->with(['unit', 'tenant'])->paginate(10);
        return response()->json($requests);
    }

    public function inProgress()
    {
        $requests = MaintenanceRequest::inProgress()->with(['unit', 'tenant'])->paginate(10);
        return response()->json($requests);
    }

    public function completed()
    {
        $requests = MaintenanceRequest::completed()->with(['unit', 'tenant'])->paginate(10);
        return response()->json($requests);
    }

    public function byPriority($priority)
    {
        $requests = MaintenanceRequest::byPriority($priority)->with(['unit', 'tenant'])->paginate(10);
        return response()->json($requests);
    }

    public function byUnit(Unit $unit)
    {
        $requests = MaintenanceRequest::where('unit_id', $unit->id)->with(['tenant', 'assignedTo'])->paginate(10);
        return response()->json($requests);
    }
}