@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-800">Rent Payment Management</h2>
                    <div class="flex space-x-2">
                        @if(Auth::user()->isLandlord())
                            <form action="{{ route('landlord.rent-payments.generate') }}" method="POST" class="inline-block">                                
                                @csrf
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Generate Monthly
                                </button>
                            </form>
                            
                            <a href="{{ route('landlord.rent-payments.create') }}"
                            class="inline-flex items-center px-3 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 ml-2">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Payment
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <form method="GET" action="{{ Auth::user()->isLandlord() ? route('landlord.rent-payments.index') : route('tenant.rent-payments.index') }}" id="search-form">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <input type="text" 
                                   name="search" 
                                   value="{{ $search ?? '' }}"
                                   placeholder="Search property or tenant..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Status</option>
                                <option value="pending" {{ ($status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ ($status ?? '') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="overdue" {{ ($status ?? '') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                            </select>
                        </div>
                        
                        @if(Auth::user()->isLandlord() && isset($properties))
                            <div>
                                <select name="property_id" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Properties</option>
                                    @foreach($properties as $property)
                                        <option value="{{ $property->id }}" {{ ($propertyId ?? '') == $property->id ? 'selected' : '' }}>
                                            {{ $property->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        
                        <div>
                            <input type="month" 
                                   name="month" 
                                   value="{{ $month ?? '' }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    
                    <div class="mt-4 flex justify-end space-x-2">
                        <button type="button" 
                                onclick="clearFilters()"
                                class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Clear
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                            Search
                        </button>
                    </div>
                </form>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 p-6">
                @if(Auth::user()->isLandlord())
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="text-blue-800 text-sm font-medium">Total Received</div>
                        <div class="text-2xl font-bold text-blue-900">${{ number_format($totalReceived ?? 0, 2) }}</div>
                    </div>
                    
                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="text-green-800 text-sm font-medium">Pending Payments</div>
                        <div class="text-2xl font-bold text-green-900">${{ number_format($totalPending ?? 0, 2) }}</div>
                    </div>
                @else
                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="text-green-800 text-sm font-medium">Total Paid</div>
                        <div class="text-2xl font-bold text-green-900">${{ number_format($totalPaid ?? 0, 2) }}</div>
                    </div>
                    
                    <div class="bg-yellow-50 rounded-lg p-4">
                        <div class="text-yellow-800 text-sm font-medium">Pending Payments</div>
                        <div class="text-2xl font-bold text-yellow-900">${{ number_format($totalPending ?? 0, 2) }}</div>
                    </div>
                @endif
                
                <div class="bg-red-50 rounded-lg p-4">
                    <div class="text-red-800 text-sm font-medium">Overdue Payments</div>
                    <div class="text-2xl font-bold text-red-900">{{ $overdueCount ?? 0 }}</div>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-gray-800 text-sm font-medium">Total Payments</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $payments->total() }}</div>
                </div>
            </div>

            <!-- Payments Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property/Tenant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="payments-table-body">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-gray-50" data-payment-id="{{ $payment->id }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $payment->property->name ?? 'Unknown Property' }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        @if(Auth::user()->isLandlord())
                                            Tenant: {{ $payment->tenant->name ?? 'Unknown Tenant' }}
                                        @else
                                            Due: {{ $payment->month_year }}
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">${{ number_format($payment->amount, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $payment->due_date->format('M d, Y') }}</div>
                                    @if($payment->payment_date)
                                        <div class="text-xs text-gray-500">Paid: {{ $payment->payment_date->format('M d, Y') }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $payment->status_badge }}-100 text-{{ $payment->status_badge }}-800">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                    @if($payment->is_overdue)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 ml-1">
                                            Overdue
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if(Auth::user()->isLandlord())
                                        @if($payment->status === 'pending')
                                            <button type="button" 
                                                    onclick="showMarkPaidModal({{ $payment->id }})"
                                                    class="text-green-600 hover:text-green-900 mr-3">
                                                Mark Paid
                                            </button>
                                        @endif
                                        <!-- Delete button for ALL payments (pending or paid) -->
                                        <button type="button" 
                                                onclick="showDeleteModal({{ $payment->id }})"
                                                class="text-red-600 hover:text-red-900 mr-3">
                                            Delete
                                        </button>
                                    @endif
                                
                                    @if(Auth::user()->isLandlord())
                                        <a href="{{ route('landlord.rent-payments.show', $payment) }}" class="text-blue-600 hover:text-blue-900">
                                            View
                                        </a>
                                        <a href="{{ route('landlord.rent-payments.pdf', $payment) }}" 
                                        target="_blank"
                                        class="text-gray-600 hover:text-gray-900 mr-3  pl-10">
                                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                            </svg>
                                        </a>
                                    @else
                                        <a href="{{ route('tenant.rent-payments.show', $payment) }}" class="text-blue-600 hover:text-blue-900">
                                            View
                                        </a>
                                        <a href="{{ route('tenant.rent-payments.pdf', $payment) }}" 
                                        target="_blank"
                                        class="text-gray-600 hover:text-gray-900 mr-3  pl-10">
                                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                            </svg>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    No rent payments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($payments->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Mark Paid Modal -->
<div id="mark-paid-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto z-50">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg shadow-xl transform transition-all sm:max-w-lg w-full">
            <form id="mark-paid-form" method="POST">
                @csrf
                @method('POST')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Mark Payment as Paid</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Please select the payment method used for this payment.</p>
                                
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                                    <select name="payment_method" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="cash">Cash</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <option value="check">Check</option>
                                        <option value="credit_card">Credit Card</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Mark as Paid
                    </button>
                    <button type="button" onclick="hideMarkPaidModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Payment Modal -->
@if(Auth::user()->isLandlord())
<div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto z-50">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg shadow-xl transform transition-all sm:max-w-lg w-full">
            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Delete Payment</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to delete this payment? This action cannot be undone.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Delete Payment
                    </button>
                    <button type="button" onclick="hideDeleteModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<script>
// Mark payment as paid (SIMPLE VERSION - NO AJAX)
function showMarkPaidModal(paymentId) {
    const form = document.getElementById('mark-paid-form');
    @if(Auth::user()->isLandlord())
        form.action = `/landlord/rent-payments/${paymentId}/mark-paid`;
    @else
        form.action = `/tenant/rent-payments/${paymentId}/mark-paid`;
    @endif
    document.getElementById('mark-paid-modal').classList.remove('hidden');
}

function hideMarkPaidModal() {
    document.getElementById('mark-paid-modal').classList.add('hidden');
}

// Delete payment (SIMPLE VERSION - NO AJAX)
function showDeleteModal(paymentId) {
    @if(Auth::user()->isLandlord())
        document.getElementById('delete-form').action = `/landlord/rent-payments/${paymentId}`;
    @endif
    document.getElementById('delete-modal').classList.remove('hidden');
}

function hideDeleteModal() {
    document.getElementById('delete-modal').classList.add('hidden');
}

// Clear filters
function clearFilters() {
    document.querySelector('input[name="search"]').value = '';
    document.querySelector('select[name="status"]').value = '';
    if (document.querySelector('select[name="property_id"]')) {
        document.querySelector('select[name="property_id"]').value = '';
    }
    document.querySelector('input[name="month"]').value = '';
    document.getElementById('search-form').submit();
}

// Close modals when clicking outside or pressing Escape
document.addEventListener('click', function(event) {
    const markPaidModal = document.getElementById('mark-paid-modal');
    const deleteModal = document.getElementById('delete-modal');
    
    if (markPaidModal && !markPaidModal.classList.contains('hidden') && event.target === markPaidModal) {
        hideMarkPaidModal();
    }
    
    if (deleteModal && !deleteModal.classList.contains('hidden') && event.target === deleteModal) {
        hideDeleteModal();
    }
});

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        hideMarkPaidModal();
        hideDeleteModal();
    }
});
</script>
@endsection