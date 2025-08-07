<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::with('user')->paginate(10);
        return response()->json($tenants);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:tenants,email',
            'phone_number' => 'required|string|max:20',
            'date_of_birth' => 'nullable|date',
            'emergency_contact' => 'nullable|array',
            'background_check_status' => 'nullable|string|in:Pending,Approved,Denied',
            'credit_score' => 'nullable|integer|min:0|max:850',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $tenant = Tenant::create($request->all());
        return response()->json($tenant, 201);
    }

    public function show(Tenant $tenant)
    {
        $tenant->load(['user', 'leases', 'payments']);
        return response()->json($tenant);
    }

    public function update(Request $request, Tenant $tenant)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:tenants,email,' . $tenant->id,
            'phone_number' => 'sometimes|string|max:20',
            'date_of_birth' => 'nullable|date',
            'emergency_contact' => 'nullable|array',
            'background_check_status' => 'nullable|string|in:Pending,Approved,Denied',
            'credit_score' => 'nullable|integer|min:0|max:850',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $tenant->update($request->all());
        return response()->json($tenant);
    }

    public function destroy(Tenant $tenant)
    {
        $tenant->delete();
        return response()->json(['message' => 'Tenant deleted successfully']);
    }
}