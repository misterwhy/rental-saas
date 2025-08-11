<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RentPayment;
use App\Models\Payment;

class TenantPaymentController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get tenant's payments
        $payments = RentPayment::where('tenant_id', $user->id)
            ->orderBy('due_date', 'desc')
            ->paginate(10);

        return view('tenant.payments.index', compact('payments'));
    }

    public function show($id)
    {
        $user = auth()->user();
        
        // Get specific payment for this tenant
        $payment = RentPayment::where('tenant_id', $user->id)
            ->findOrFail($id);

        return view('tenant.payments.show', compact('payment'));
    }

    public function downloadPDF($id)
    {
        $user = auth()->user();
        
        // Get specific payment for this tenant
        $payment = RentPayment::where('tenant_id', $user->id)
            ->findOrFail($id);

        // Generate and download PDF
        // You'll need to implement this based on your PDF generation logic
        // This is just a placeholder
        return response()->download('path/to/payment-'.$payment->id.'.pdf');
    }
}