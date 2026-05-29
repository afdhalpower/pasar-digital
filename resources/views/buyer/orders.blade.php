@extends('layouts.marketplace')

@section('title', __('marketplace.orders_title'))

@php $hasFilter = request()->anyFilled(['search', 'payment', 'status']); @endphp

@section('content')
<div class="container" style="padding-top: 120px; padding-bottom: var(--space-8); min-height: 85vh;">
    <div style="display: grid; grid-template-columns: 280px 1fr; gap: var(--space-5);" class="dashboard-grid">
        @include('buyer.sidebar')

        <main class="dashboard-content-area animate-in">
            <div style="margin-bottom: var(--space-4);">
                <span class="label-sm" style="color: var(--color-primary);">{{ __('marketplace.orders_badge') }}</span>
                <h1 class="headline-md" style="margin-top: 4px;">{{ __('marketplace.orders_title') }}</h1>
                <p style="color: var(--color-on-surface-variant); font-size: 0.875rem;">{{ __('marketplace.orders_subtitle') }}</p>
            </div>

            <form method="GET" action="{{ route('buyer.orders') }}" style="display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: var(--space-4);">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('marketplace.orders_search') }}" class="input-field" style="max-width: 260px;">
                <select name="payment" class="input-field" style="max-width: 160px;" onchange="this.form.submit()">
                    <option value="">{{ __('marketplace.orders_filter_all') }}</option>
                    <option value="paid" {{ request('payment') == 'paid' ? 'selected' : '' }}>{{ __('marketplace.orders_filter_paid') }}</option>
                    <option value="unpaid" {{ request('payment') == 'unpaid' ? 'selected' : '' }}>{{ __('marketplace.orders_filter_unpaid') }}</option>
                    <option value="failed" {{ request('payment') == 'failed' ? 'selected' : '' }}>{{ __('marketplace.orders_filter_failed') }}</option>
                    <option value="refunded" {{ request('payment') == 'refunded' ? 'selected' : '' }}>{{ __('marketplace.orders_filter_refund') }}</option>
                </select>
                <select name="status" class="input-field" style="max-width: 160px;" onchange="this.form.submit()">
                    <option value="">{{ __('marketplace.orders_status_all') }}</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('marketplace.orders_status_pending') }}</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>{{ __('marketplace.orders_status_processing') }}</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('marketplace.orders_status_completed') }}</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ __('marketplace.orders_status_cancelled') }}</option>
                </select>
                <button type="submit" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.8rem;">{{ __('marketplace.orders_filter_button') }}</button>
                @if($hasFilter)
                    <a href="{{ route('buyer.orders') }}" class="btn btn-secondary" style="padding: 8px 16px; font-size: 0.8rem;">{{ __('marketplace.orders_reset_button') }}</a>
                @endif
            </form>

            <div style="background: var(--color-surface-container); border: 1px solid var(--color-outline-variant); border-radius: var(--radius-lg); padding: var(--space-4);">
                <div style="overflow-x: auto;">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>{{ __('marketplace.dashboard_order_number') }}</th>
                                <th>{{ __('marketplace.dashboard_order_date') }}</th>
                                <th>{{ __('marketplace.dashboard_payment_method') }}</th>
                                <th>{{ __('marketplace.dashboard_total') }}</th>
                                <th>{{ __('marketplace.dashboard_payment_status') }}</th>
                                <th>{{ __('marketplace.dashboard_order_status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('buyer.order.detail', $order) }}" style="font-weight: 600; color: var(--color-on-surface); text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color='var(--color-on-surface)'">
                                            {{ $order->order_number }}
                                        </a>
                                    </td>
                                    <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                                    <td>{{ $order->payment_method ? strtoupper(str_replace('_', ' ', $order->payment_method)) : '-' }}</td>
                                    <td style="font-weight: 600; color: var(--color-primary);">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($order->payment_status === 'paid')
                                            <span class="badge badge-success">{{ __('marketplace.dashboard_paid') }}</span>
                                        @elseif ($order->payment_status === 'failed')
                                            <span class="badge badge-danger">{{ __('marketplace.dashboard_failed') }}</span>
                                        @elseif ($order->payment_status === 'refunded')
                                            <span class="badge badge-info">{{ __('marketplace.dashboard_refunded') }}</span>
                                        @else
                                            <span class="badge badge-warning">{{ __('marketplace.dashboard_unpaid') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($order->status === 'completed')
                                            <span class="badge badge-success">{{ __('marketplace.dashboard_completed') }}</span>
                                        @elseif ($order->status === 'pending')
                                            <span class="badge badge-warning">{{ __('marketplace.dashboard_pending') }}</span>
                                        @elseif ($order->status === 'processing')
                                            <span class="badge badge-info">{{ __('marketplace.dashboard_processing') }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ ucfirst($order->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 60px 0;">
                                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--color-outline)" stroke-width="1.5" style="margin-bottom:16px;"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                                        <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--color-on-surface); margin-bottom: 8px;">
                                            @if($hasFilter)
                                                {{ __('marketplace.orders_empty_filter') }}
                                            @else
                                                {{ __('marketplace.orders_empty_no_orders') }}
                                            @endif
                                        </h3>
                                        <p style="color: var(--color-on-surface-variant); font-size: 0.875rem; margin-bottom: 20px;">
                                            @if($hasFilter)
                                                {{ __('marketplace.orders_empty_text') }}
                                            @else
                                                {{ __('marketplace.orders_empty_no_purchases') }}
                                            @endif
                                        </p>
                                        @unless($hasFilter)
                                            <a href="{{ route('catalog.index') }}" class="btn btn-primary" style="padding: 8px 20px; font-size: 0.875rem;">{{ __('marketplace.orders_empty_cta') }}</a>
                                        @endunless
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($orders->hasPages())
                    <div style="display:flex; justify-content:center; margin-top:var(--space-4);">
                        {{ $orders->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>
@endsection
