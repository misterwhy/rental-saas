@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-800">Add New Rent Payment</h2>
                    <a href="{{ route('rent-payments.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                        ← Back to Payments
                    </a>
                </div>
            </div>

            <form method="POST" action="{{ route('rent-payments.store') }}" class="p-6">
                @csrf
                
                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <div class="text-red-800 font-medium">Please fix the following errors:</div>
                        <ul class="mt-2 text-red-700 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Property -->
                    <div class="md:col-span-2">
                        <label for="property_id" class="block text-sm font-medium text-gray-700 mb-1">Property</label>
                        <select id="property_id" name="property_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select a property</option>
                            @foreach($properties as $property)
                                <option value="{{ $property->id }}" data-rent="{{ $property->purchase_price > 0 ? $property->purchase_price : 1000 }}" {{ old('property_id') == $property->id ? 'selected' : '' }}>
                                    {{ $property->name }} - ${{ number_format($property->purchase_price > 0 ? $property->purchase_price : 1000, 2) }}/month
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tenant -->
                    <div class="md:col-span-2">
                        <label for="tenant_id" class="block text-sm font-medium text-gray-700 mb-1">Tenant</label>
                        <select id="tenant_id" name="tenant_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select a tenant</option>
                            @foreach($tenants as $tenant)
                                <option value="{{ $tenant->id }}" {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                    {{ $tenant->name }} ({{ $tenant->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Rent Amount (Auto-calculated) -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Monthly Rent Amount</label>
                        <div class="px-3 py-2 bg-blue-50 rounded-md border border-blue-200">
                            <span id="rent-amount-display" class="text-lg font-medium text-blue-800">
                                ${{ number_format(0, 2) }}
                            </span>
                            <span class="text-sm text-blue-600 block mt-1">
                                This amount is automatically calculated from the property's purchase price
                            </span>
                            <input type="hidden" name="amount" id="amount-input" value="0">
                        </div>
                    </div>

                    <!-- Due Date -->
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Due Date</label>
                        <input type="date" id="due_date" name="due_date" 
                               value="{{ old('due_date', now()->endOfMonth()->format('Y-m-d')) }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Payment Method -->
                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                        <select id="payment_method" name="payment_method"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Not specified</option>
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="check" {{ old('payment_method') == 'check' ? 'selected' : '' }}>Check</option>
                            <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                            <option value="other" {{ old('payment_method') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <!-- Notes -->
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional)</label>
                        <textarea id="notes" name="notes" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Add any additional notes about this payment...">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('rent-payments.index') }}" 
                           class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                            Create Payment
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const propertySelect = document.getElementById('property_id');
    const rentAmountDisplay = document.getElementById('rent-amount-display');
    const amountInput = document.getElementById('amount-input');
    
    // Update rent amount when property is selected
    propertySelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const rentAmount = selectedOption.getAttribute('data-rent') || 0;
        
        // Update display
        rentAmountDisplay.textContent = '$' + parseFloat(rentAmount).toFixed(2);
        
        // Update hidden input
        amountInput.value = rentAmount;
    });
    
    // Trigger change event on page load to set initial value
    if (propertySelect.value) {
        propertySelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection