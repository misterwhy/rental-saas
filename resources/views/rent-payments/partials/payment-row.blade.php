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
        @if(Auth::user()->isLandlord() && $payment->status === 'pending')
            <button type="button" 
                    onclick="showMarkPaidModal({{ $payment->id }})"
                    class="text-green-600 hover:text-green-900 mr-3">
                Mark Paid
            </button>
        @endif
        <a href="{{ route('rent-payments.show', $payment) }}" class="text-blue-600 hover:text-blue-900">
            View
        </a>
    </td>
</tr>