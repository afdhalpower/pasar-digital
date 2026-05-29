<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('marketplace.invoice_title') }} #{{ $order->order_number }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #fff;
            color: #111;
            font-size: 14px;
            line-height: 1.5;
            padding: 40px;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 32px;
            padding-bottom: 24px;
            border-bottom: 2px solid #0d9488;
        }
        .invoice-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0d9488;
        }
        .invoice-title {
            text-align: right;
        }
        .invoice-title h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #111;
        }
        .invoice-title p {
            color: #666;
            font-size: 0.875rem;
        }
        .invoice-body {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 32px;
        }
        .invoice-section h3 {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #666;
            margin-bottom: 8px;
        }
        .invoice-section p {
            color: #111;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        .invoice-table th {
            text-align: left;
            padding: 12px 16px;
            background: #f5f5f5;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #666;
            border-bottom: 1px solid #e0e0e0;
        }
        .invoice-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #eee;
            color: #333;
        }
        .invoice-table td:last-child,
        .invoice-table th:last-child {
            text-align: right;
        }
        .invoice-summary {
            margin-left: auto;
            width: 320px;
        }
        .invoice-summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 16px;
        }
        .invoice-summary-row.total {
            border-top: 2px solid #0d9488;
            margin-top: 8px;
            padding-top: 12px;
            font-weight: 700;
            font-size: 1.125rem;
            color: #0d9488;
        }
        .invoice-footer {
            margin-top: 48px;
            padding-top: 24px;
            border-top: 1px solid #e0e0e0;
            text-align: center;
            font-size: 0.8rem;
            color: #999;
        }
        @media print {
            body { padding: 20px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <div>
            <div class="invoice-brand">{{ __('marketplace.brand') }}</div>
            <p style="color: #666; font-size: 0.8rem; margin-top: 4px;">{{ __('marketplace.invoice_brand_subtitle') }}</p>
        </div>
        <div class="invoice-title">
            <h1>{{ __('marketplace.invoice_title') }}</h1>
            <p>#{{ $order->order_number }}</p>
        </div>
    </div>

    <div class="invoice-body">
        <div class="invoice-section">
            <h3>{{ __('marketplace.invoice_for') }}</h3>
            <p style="font-weight: 600;">{{ $order->user->name }}</p>
            <p>{{ $order->user->email }}</p>
        </div>
        <div class="invoice-section" style="text-align: right;">
            <h3>{{ __('marketplace.invoice_detail') }}</h3>
            <p>{{ __('marketplace.invoice_date') }} {{ $order->created_at->format('d M Y, H:i') }}</p>
            <p>{{ __('marketplace.invoice_status') }} 
                @if($order->payment_status === 'paid')
                    <span style="color: #10B981; font-weight: 600;">{{ __('marketplace.invoice_paid') }}</span>
                @else
                    <span style="color: #F59E0B; font-weight: 600;">{{ strtoupper($order->payment_status) }}</span>
                @endif
            </p>
        </div>
    </div>

    <table class="invoice-table">
        <thead>
            <tr>
                <th style="width: 60%;">{{ __('marketplace.invoice_product') }}</th>
                <th>{{ __('marketplace.invoice_price') }}</th>
                <th>{{ __('marketplace.invoice_qty') }}</th>
                <th>{{ __('marketplace.invoice_subtotal') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product?->name ?? __('marketplace.product_deleted') }}</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="invoice-summary">
        <div class="invoice-summary-row">
            <span>{{ __('marketplace.invoice_subtotal') }}</span>
            <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
        </div>
        @if($order->discount > 0)
            <div class="invoice-summary-row" style="color: #10B981;">
                <span>{{ __('marketplace.invoice_discount') }}</span>
                <span>- Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
            </div>
        @endif
        <div class="invoice-summary-row">
            <span>{{ __('marketplace.invoice_unique_code') }}</span>
            <span>+ Rp {{ number_format($order->unique_code, 0, ',', '.') }}</span>
        </div>
        <div class="invoice-summary-row total">
            <span>{{ __('marketplace.invoice_total_transfer') }}</span>
            <span>Rp {{ number_format($order->total_transfer, 0, ',', '.') }}</span>
        </div>
    </div>

    <div style="text-align: center; margin-top: 24px;" class="no-print">
        <button onclick="window.print()" style="padding: 12px 32px; background: #0d9488; color: #fff; border: none; border-radius: 8px; font-family: 'Inter', sans-serif; font-size: 0.875rem; font-weight: 600; cursor: pointer;">
            {{ __('marketplace.invoice_print') }}
        </button>
    </div>

    <div class="invoice-footer">
        <p>{{ __('marketplace.invoice_footer') }}</p>
        <p style="margin-top: 4px;">{{ __('marketplace.invoice_thanks') }}</p>
    </div>
</body>
</html>
