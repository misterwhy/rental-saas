@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Payment Details</h2>
                    <a href="{{ route('tenant.rent-payments.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                        Back to Payments
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Payment Information</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-gray-600">Property:</span>
                                <span class="ml-2 font-medium">
                                    {{ $rentPayment->property->address ?? 'N/A' }}
                                </span>
                            </div>
                            <div>
                                <span class="text-gray-600">Amount:</span>
                                <span class="ml-2 font-medium text-xl text-green-600">
                                    ${{ number_format($rentPayment->amount, 2) }}
                                </span>
                            </div>
                            <div>
                                <span class="text-gray-600">Due Date:</span>
                                <span class="ml-2 font-medium">
                                    {{ $rentPayment->due_date->format('M d, Y') }}
                                </span>
                            </div>
                            <div>
                                <span class="text-gray-600">Status:</span>
                                <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $rentPayment->status === 'paid' ? 'bg-green-100 text-green-800' : 
                                       ($rentPayment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                        'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($rentPayment->status) }}
                                </span>
                            </div>
                            <div>
                                <span class="text-gray-600">Payment Date:</span>
                                <span class="ml-2 font-medium">
                                    {{ $rentPayment->paid_at ? $rentPayment->paid_at->format('M d, Y') : 'Not paid yet' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Actions</h3>
                        @if($rentPayment->status !== 'paid')
                            <div class="space-y-3">
                                <button onclick="showPaymentModal({{ $rentPayment->id }})" class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Make Payment
                                </button>
                                
                                <a href="{{ route('tenant.rent-payments.pdf', $rentPayment) }}" 
                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    Download Receipt
                                </a>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="text-green-600 font-medium">Payment Completed</div>
                                <a href="{{ route('tenant.rent-payments.pdf', $rentPayment) }}" 
                                class="mt-2 inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    Download Receipt
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Payment Modal -->
<div id="payment-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto z-50">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg shadow-xl transform transition-all sm:max-w-lg w-full">
            <form id="payment-form" method="POST">
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
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Make Payment</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Please select the payment method for this payment.</p>
                                
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
                    <button type="button" onclick="hidePaymentModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Show payment modal
function showPaymentModal(paymentId) {
    const form = document.getElementById('payment-form');
    form.action = `/tenant/rent-payments/${paymentId}/mark-paid`;
    document.getElementById('payment-modal').classList.remove('hidden');
}

// Hide payment modal
function hidePaymentModal() {
    document.getElementById('payment-modal').classList.add('hidden');
}

// Close modal when clicking outside or pressing Escape
document.addEventListener('click', function(event) {
    const paymentModal = document.getElementById('payment-modal');
    
    if (paymentModal && !paymentModal.classList.contains('hidden') && event.target === paymentModal) {
        hidePaymentModal();
    }
});

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        hidePaymentModal();
    }
});
</script>

@endsection