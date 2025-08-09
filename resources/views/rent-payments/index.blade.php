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
                            <button type="button" 
                                    id="generate-payments-btn"
                                    class="inline-flex items-center px-3 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Generate Monthly
                            </button>
                            <a href="{{ route('rent-payments.create') }}" 
                               class="inline-flex items-center px-3 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
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
                <form method="GET" action="{{ route('rent-payments.index') }}" id="search-form">
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
                            @include('rent-payments.partials.payment-row', ['payment' => $payment])
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
                    <button type="button" onclick="document.getElementById('mark-paid-modal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
                
            </form>
        </div>
    </div>
</div>

<script>
// Auto-refresh functionality
let refreshInterval;

function startAutoRefresh() {
    refreshInterval = setInterval(function() {
        // Reload the search form to refresh data
        const formData = new FormData(document.getElementById('search-form'));
        const searchParams = new URLSearchParams();
        for (const [key, value] of formData) {
            if (value) {
                searchParams.append(key, value);
            }
        }
        
        fetch('{{ route('rent-payments.index') }}?' + searchParams.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            // Parse the response and update the table
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTableBody = doc.querySelector('#payments-table-body');
            if (newTableBody) {
                document.querySelector('#payments-table-body').innerHTML = newTableBody.innerHTML;
            }
        })
        .catch(error => console.error('Auto-refresh error:', error));
    }, 30000); // Refresh every 30 seconds
}

function stopAutoRefresh() {
    if (refreshInterval) {
        clearInterval(refreshInterval);
    }
}

// Generate monthly payments with AJAX
document.getElementById('generate-payments-btn').addEventListener('click', function() {
    if (confirm('Are you sure you want to generate monthly payments for all properties with tenants?')) {
        fetch('{{ route('rent-payments.generate') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                // Refresh the page to show new payments
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error generating payments');
        });
    }
});

// Mark payment as paid with AJAX
function showMarkPaidModal(paymentId) {
    const form = document.getElementById('mark-paid-form');
    form.action = `/rent-payments/${paymentId}/mark-paid`;
    document.getElementById('mark-paid-modal').classList.remove('hidden');
}

// Handle mark paid form submission with AJAX
document.getElementById('mark-paid-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const formData = new FormData(form);
    
    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            document.getElementById('mark-paid-modal').classList.add('hidden');
            // Refresh the page to show updated status
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error marking payment as paid');
    });
});

// Clear filters
function clearFilters() {
    document.querySelector('input[name="search"]').value = '';
    document.querySelector('select[name="status"]').value = '';
    document.querySelector('select[name="property_id"]').value = '';
    document.querySelector('input[name="month"]').value = '';
    document.getElementById('search-form').submit();
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('mark-paid-modal');
    if (modal && !modal.classList.contains('hidden') && event.target === modal) {
        modal.classList.add('hidden');
    }
});

// Start auto-refresh when page loads
document.addEventListener('DOMContentLoaded', function() {
    startAutoRefresh();
});

// Stop auto-refresh when leaving page
window.addEventListener('beforeunload', function() {
    stopAutoRefresh();
});
</script>
@endsection