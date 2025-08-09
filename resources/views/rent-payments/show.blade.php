@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-800">Payment Details</h2>
                    <a href="{{ route('rent-payments.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                        ← Back to Payments
                    </a>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Payment Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Information</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Payment ID:</span>
                                <span class="font-medium">#{{ $rentPayment->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Amount:</span>
                                <span class="font-medium text-lg text-green-600">${{ number_format($rentPayment->amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Due Date:</span>
                                <span class="font-medium">{{ $rentPayment->due_date->format('F d, Y') }}</span>
                            </div>
                            @if($rentPayment->payment_date)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Payment Date:</span>
                                    <span class="font-medium">{{ $rentPayment->payment_date->format('F d, Y') }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $rentPayment->status_badge }}-100 text-{{ $rentPayment->status_badge }}-800">
                                    {{ ucfirst($rentPayment->status) }}
                                </span>
                            </div>
                            @if($rentPayment->payment_method)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Payment Method:</span>
                                    <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $rentPayment->payment_method)) }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Property/Tenant Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Related Information</h3>
                        <div class="space-y-4">
                            <div>
                                <span class="text-gray-600 block text-sm">Property:</span>
                                <span class="font-medium">{{ $rentPayment->property->name ?? 'Unknown Property' }}</span>
                                <span class="text-sm text-gray-500 block">
                                    {{ $rentPayment->property->address ?? '' }}<br>
                                    {{ $rentPayment->property->city ?? '' }}, {{ $rentPayment->property->state ?? '' }} {{ $rentPayment->property->zip_code ?? '' }}
                                </span>
                            </div>
                            
                            @if(Auth::user()->isLandlord())
                                <div>
                                    <span class="text-gray-600 block text-sm">Tenant:</span>
                                    <span class="font-medium">{{ $rentPayment->tenant->name ?? 'Unknown Tenant' }}</span>
                                    @if($rentPayment->tenant->email)
                                        <span class="text-sm text-gray-500 block">{{ $rentPayment->tenant->email }}</span>
                                    @endif
                                </div>
                            @endif
                            
                            <div>
                                <span class="text-gray-600 block text-sm">Period:</span>
                                <span class="font-medium">{{ $rentPayment->due_date->format('F Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes Section -->
                @if($rentPayment->notes)
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Notes</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700">{{ $rentPayment->notes }}</p>
                        </div>
                    </div>
                @endif



                <!-- Actions -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-500">
                            Created: {{ $rentPayment->created_at->format('M d, Y g:i A') }}
                            @if($rentPayment->updated_at != $rentPayment->created_at)
                                <br>Updated: {{ $rentPayment->updated_at->format('M d, Y g:i A') }}
                            @endif
                        </div>
                        
                        <div class="flex space-x-3">
                            <a href="{{ route('rent-payments.index') }}" 
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Back to List
                            </a>
                            
                            @if(Auth::user()->isLandlord())
                                @if($rentPayment->status === 'pending')
                                    <button type="button" 
                                            onclick="showMarkPaidModal({{ $rentPayment->id }})"
                                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                                        Mark as Paid
                                    </button>
                                @elseif($rentPayment->status === 'paid')
                                    <!-- Delete button for paid payments -->
                                    <button type="button" 
                                            onclick="showDeleteModal({{ $rentPayment->id }})"
                                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                                        Delete Payment
                                    </button>
                                @endif
                                
                                <!-- Edit button -->
                                <a href="{{ route('rent-payments.edit', $rentPayment) }}" 
                                class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                    Edit
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                









            </div>
        </div>
    </div>
</div>

<!-- Mark Paid Modal (if user is landlord) -->
@if(Auth::user()->isLandlord() && $rentPayment->status === 'pending')
<div id="mark-paid-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto z-50">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg shadow-xl transform transition-all sm:max-w-lg w-full">
            <form id="mark-paid-form" method="POST" action="{{ route('rent-payments.mark-paid', $rentPayment) }}">
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
                                    <br><br>
                                    <strong>Payment Details:</strong><br>
                                    Amount: $<span id="delete-amount">0.00</span><br>
                                    Property: <span id="delete-property">Unknown</span><br>
                                    Period: <span id="delete-period">Unknown</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Delete Payment
                    </button>
                    <button type="button" onclick="document.getElementById('delete-modal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Add this function to show the delete modal
function showDeleteModal(paymentId) {
    // Set the form action
    document.getElementById('delete-form').action = `/rent-payments/${paymentId}`;
    
    // Set payment details in the modal (optional - you can fetch these via AJAX)
    document.getElementById('delete-amount').textContent = '{{ number_format($rentPayment->amount, 2) }}';
    document.getElementById('delete-property').textContent = '{{ $rentPayment->property->name ?? 'Unknown Property' }}';
    document.getElementById('delete-period').textContent = '{{ $rentPayment->due_date->format('F Y') }}';
    
    // Show the modal
    document.getElementById('delete-modal').classList.remove('hidden');
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const deleteModal = document.getElementById('delete-modal');
    if (deleteModal && !deleteModal.classList.contains('hidden') && event.target === deleteModal) {
        deleteModal.classList.add('hidden');
    }
});
</script>
@endif
<script>
function showMarkPaidModal(paymentId) {
    document.getElementById('mark-paid-modal').classList.remove('hidden');
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('mark-paid-modal');
    if (modal && !modal.classList.contains('hidden') && event.target === modal) {
        modal.classList.add('hidden');
    }
});
</script>
@endif
@endsection