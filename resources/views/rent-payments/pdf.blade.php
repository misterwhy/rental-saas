<!DOCTYPE html>
<html>
<head>
    <title>Payment Receipt #{{ $rentPayment->id }}</title>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .receipt-title {
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-row {
            margin-bottom: 8px;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            margin: 15px 0 10px 0;
        }
        .total-amount {
            font-size: 16px;
            font-weight: bold;
            text-align: right;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .status-paid {
            color: #28a745;
            font-weight: bold;
        }
        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            opacity: 0.1;
            font-size: 48px;
            font-weight: bold;
            color: #000;
            pointer-events: none;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="watermark">
        @if($rentPayment->status === 'paid')
            PAID
        @else
            {{ strtoupper($rentPayment->status) }}
        @endif
    </div>
    
    <div class="header">
        <div class="company-name">Property Management System</div>
        <div class="receipt-title">PAYMENT RECEIPT</div>
        <div>Receipt #: {{ $rentPayment->id }}</div>
        <div>Date: {{ now()->format('F d, Y') }}</div>
    </div>

    <div class="info-section">
        <div class="section-title">Payment Information</div>
        <div class="info-row">
            <span class="info-label">Amount:</span>
            <span>${{ number_format($rentPayment->amount, 2) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Due Date:</span>
            <span>{{ $rentPayment->due_date->format('F d, Y') }}</span>
        </div>
        @if($rentPayment->payment_date)
            <div class="info-row">
                <span class="info-label">Payment Date:</span>
                <span>{{ $rentPayment->payment_date->format('F d, Y') }}</span>
            </div>
        @endif
        <div class="info-row">
            <span class="info-label">Status:</span>
            <span class="{{ $rentPayment->status === 'paid' ? 'status-paid' : 'status-pending' }}">
                {{ ucfirst($rentPayment->status) }}
            </span>
        </div>
        @if($rentPayment->payment_method)
            <div class="info-row">
                <span class="info-label">Payment Method:</span>
                <span>{{ ucfirst(str_replace('_', ' ', $rentPayment->payment_method)) }}</span>
            </div>
        @endif
    </div>

    <div class="info-section">
        <div class="section-title">Property Information</div>
        <div class="info-row">
            <span class="info-label">Property:</span>
            <span>{{ $rentPayment->property->name ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Address:</span>
            <span>
                {{ $rentPayment->property->address ?? '' }}<br>
                {{ $rentPayment->property->city ?? '' }}, {{ $rentPayment->property->state ?? '' }} {{ $rentPayment->property->zip_code ?? '' }}
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Period:</span>
            <span>{{ $rentPayment->due_date->format('F Y') }}</span>
        </div>
    </div>

    @if(Auth::user()->isLandlord())
        <div class="info-section">
            <div class="section-title">Tenant Information</div>
            <div class="info-row">
                <span class="info-label">Name:</span>
                <span>{{ $rentPayment->tenant->name ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email:</span>
                <span>{{ $rentPayment->tenant->email ?? 'N/A' }}</span>
            </div>
        </div>
    @endif

    @if($rentPayment->notes)
        <div class="info-section">
            <div class="section-title">Notes</div>
            <div>{{ $rentPayment->notes }}</div>
        </div>
    @endif

    <div class="total-amount">
        TOTAL PAID: ${{ number_format($rentPayment->amount, 2) }}
    </div>

    <div class="footer">
        <div>Thank you for your payment!</div>
        <div>This is an official receipt. Please keep it for your records.</div>
        <div>Generated on {{ now()->format('F d, Y g:i A') }}</div>
    </div>
</body>
</html>