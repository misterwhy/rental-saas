<?php

namespace App\Http\Controllers;

use App\Models\Lease;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeaseController extends Controller
{
    public function index()
    {
        $leases = Lease::with(['unit.property', 'tenants'])->paginate(10);
        return response()->json($leases);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unit_id' => 'required|exists:units,id',
            'tenant_ids' => 'required|array',
            'tenant_ids.*' => 'exists:tenants,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'rent_amount' => 'required|numeric|min:0',
            'deposit_amount' => 'required|numeric|min:0',
            'status' => 'required|string|in:Active,Expired,Pending Renewal',
            'payment_frequency' => 'required|string|in:Monthly,Quarterly',
            'late_fee_policy' => 'nullable|string',
            'documents' => 'nullable|array',
            'last_payment_date' => 'nullable|date',
            'next_payment_due_date' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $lease = Lease::create($request->all());
        
        // Sync tenants
        $lease->tenants()->sync($request->tenant_ids);
        
        return response()->json($lease->load('tenants'), 201);
    }

    public function show(Lease $lease)
    {
        $lease->load(['unit.property', 'tenants', 'payments']);
        return response()->json($lease);
    }

    public function update(Request $request, Lease $lease)
    {
        $validator = Validator::make($request->all(), [
            'unit_id' => 'sometimes|exists:units,id',
            'tenant_ids' => 'sometimes|array',
            'tenant_ids.*' => 'exists:tenants,id',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after:start_date',
            'rent_amount' => 'sometimes|numeric|min:0',
            'deposit_amount' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|string|in:Active,Expired,Pending Renewal',
            'payment_frequency' => 'sometimes|string|in:Monthly,Quarterly',
            'late_fee_policy' => 'nullable|string',
            'documents' => 'nullable|array',
            'last_payment_date' => 'nullable|date',
            'next_payment_due_date' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $lease->update($request->all());
        
        // Sync tenants if provided
        if ($request->has('tenant_ids')) {
            $lease->tenants()->sync($request->tenant_ids);
        }
        
        return response()->json($lease->load('tenants'));
    }

    public function destroy(Lease $lease)
    {
        $lease->delete();
        return response()->json(['message' => 'Lease deleted successfully']);
    }

    public function active()
    {
        $leases = Lease::active()->with(['unit', 'tenants'])->paginate(10);
        return response()->json($leases);
    }

    public function expired()
    {
        $leases = Lease::expired()->with(['unit', 'tenants'])->paginate(10);
        return response()->json($leases);
    }
}