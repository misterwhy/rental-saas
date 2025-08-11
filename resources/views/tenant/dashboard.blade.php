@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-bold mb-6">Tenant Dashboard</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Active Lease Card -->
                    <div class="bg-blue-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Active Lease</h3>
                        @if($activeLease)
                            <p><strong>Property:</strong> {{ $activeLease->property->address ?? 'N/A' }}</p>
                            <p><strong>Monthly Rent:</strong> ${{ number_format($activeLease->monthly_rent, 2) }}</p>
                            <p><strong>Lease Period:</strong> {{ $activeLease->start_date->format('M d, Y') }} - {{ $activeLease->end_date->format('M d, Y') }}</p>
                        @else
                            <p>No active lease found.</p>
                        @endif
                    </div>
                    
                    <!-- Upcoming Payment Card -->
                    <div class="bg-green-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Next Payment Due</h3>
                        @if($upcomingPayment)
                            <p class="text-2xl font-bold text-green-600">${{ number_format($upcomingPayment->amount, 2) }}</p>
                            <p><strong>Due Date:</strong> {{ $upcomingPayment->due_date->format('M d, Y') }}</p>
                            <p><strong>Status:</strong> <span class="badge bg-warning">{{ ucfirst($upcomingPayment->status) }}</span></p>
                        @else
                            <p>No upcoming payments.</p>
                        @endif
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Recent Payments -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Recent Payments</h3>
                        @if($recentPayments && $recentPayments->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr>
                                            <th class="py-2 px-4 border-b">Date</th>
                                            <th class="py-2 px-4 border-b">Amount</th>
                                            <th class="py-2 px-4 border-b">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentPayments as $payment)
                                            <tr>
                                                <td class="py-2 px-4 border-b">{{ $payment->created_at->format('M d, Y') }}</td>
                                                <td class="py-2 px-4 border-b">${{ number_format($payment->amount, 2) }}</td>
                                                <td class="py-2 px-4 border-b">
                                                    <span class="badge bg-{{ $payment->status === 'paid' ? 'success' : 'warning' }}">
                                                        {{ ucfirst($payment->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p>No payment history found.</p>
                        @endif
                    </div>
                    
                    <!-- Maintenance Requests -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Recent Maintenance Requests</h3>
                        @if($maintenanceRequests && $maintenanceRequests->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr>
                                            <th class="py-2 px-4 border-b">Date</th>
                                            <th class="py-2 px-4 border-b">Issue</th>
                                            <th class="py-2 px-4 border-b">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($maintenanceRequests as $request)
                                            <tr>
                                                <td class="py-2 px-4 border-b">{{ $request->created_at->format('M d, Y') }}</td>
                                                <td class="py-2 px-4 border-b">{{ Str::limit($request->issue_description, 30) }}</td>
                                                <td class="py-2 px-4 border-b">
                                                    <span class="badge bg-{{ $request->status === 'completed' ? 'success' : ($request->status === 'in_progress' ? 'info' : 'warning') }}">
                                                        {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p>No maintenance requests found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection