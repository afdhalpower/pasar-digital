@extends('layouts.marketplace')

@section('title', __('marketplace.order_detail_title', ['number' => $order->order_number]))

@push('styles')
<style>
.order-step-label { font-size: 0.75rem; font-weight: 600; }
.order-step-time { font-size: 0.65rem; color: var(--color-on-surface-variant); margin-top: 2px; }
</style>
@endpush

@php
$steps = [
    ['label' => __('marketplace.order_detail_step_created'), 'key' => 'created', 'done' => true, 'time' => $order->created_at],
    ['label' => __('marketplace.order_detail_step_paid'), 'key' => 'paid', 'done' => in_array($order->payment_status, ['paid', 'refunded']), 'time' => $order->payment_status === 'paid' ? $order->updated_at : null],
    ['label' => __('marketplace.order_detail_step_processing'), 'key' => 'processing', 'done' => in_array($order->status, ['processing', 'completed']), 'time' => $order->status === 'processing' ? $order->updated_at : null],
    ['label' => __('marketplace.order_detail_step_completed'), 'key' => 'completed', 'done' => $order->status === 'completed', 'time' => $order->status === 'completed' ? $order->updated_at : null],
];
@endphp

@section('content')
<div class="container" style="padding-top: 120px; padding-bottom: var(--space-8); min-height: 85vh;">
    <div style="display: grid; grid-template-columns: 280px 1fr; gap: var(--space-5);" class="dashboard-grid">
        @include('buyer.sidebar')

        <main class="dashboard-content-area animate-in">
            <a href="{{ route('buyer.orders') }}" class="label-sm" style="color: var(--color-primary); text-decoration: none; display: inline-flex; align-items: center; gap: 4px; margin-bottom: var(--space-2);">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                {{ __('marketplace.order_detail_back') }}
            </a>
            <h1 class="headline-md" style="margin-top: 4px;">{{ __('marketplace.order_detail_heading') }}</h1>
            <p style="color: var(--color-on-surface-variant); font-size: 0.875rem;">{{ __('marketplace.order_detail_number_label') }} <strong style="color: var(--color-on-surface);">{{ $order->order_number }}</strong></p>

            {{-- Status Timeline --}}
            <div style="background: var(--color-surface-container); border: 1px solid var(--color-outline-variant); border-radius: var(--radius-lg); padding: var(--space-4); margin-top: var(--space-4);">
                <h3 style="font-family: var(--font-headline); font-size: 1.125rem; font-weight: 600; margin-bottom: var(--space-3);">{{ __('marketplace.order_detail_status_heading') }}</h3>
                <div style="display: flex; gap: 0; position: relative;">
                    @foreach($steps as $i => $step)
                        <div style="flex: 1; text-align: center; position: relative;">
                            {{-- Connector line --}}
                            @if($i < count($steps) - 1)
                                <div style="position: absolute; top: 16px; left: 60%; right: -40%; height: 2px; background: {{ $step['done'] ? 'var(--color-primary)' : 'var(--color-outline-variant)' }}; z-index: 0;"></div>
                            @endif
                            {{-- Circle --}}
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: {{ $step['done'] ? 'var(--color-primary)' : 'var(--color-surface-container-high)' }}; border: 2px solid {{ $step['done'] ? 'var(--color-primary)' : 'var(--color-outline-variant)' }}; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; position: relative; z-index: 1;">
                                @if($step['done'])
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--color-on-primary)" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                @else
                                    <span style="font-size: 0.75rem; color: var(--color-on-surface-variant);">{{ $i + 1 }}</span>
                                @endif
                            </div>
                            <div>
                                <p class="order-step-label" style="color: {{ $step['done'] ? 'var(--color-primary)' : 'var(--color-on-surface-variant)' }};">{{ $step['label'] }}</p>
                                @if($step['time'])
                                    <p class="order-step-time">{{ $step['time']->format('d M Y, H:i') }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Order Summary --}}
            <div style="background: var(--color-surface-container); border: 1px solid var(--color-outline-variant); border-radius: var(--radius-lg); padding: var(--space-4); margin-top: var(--space-4);">
                <h3 style="font-family: var(--font-headline); font-size: 1.125rem; font-weight: 600; margin-bottom: var(--space-3);">{{ __('marketplace.order_detail_summary') }}</h3>
                <div style="display: flex; flex-direction: column; gap: 12px; font-size: 0.875rem;">
                    <div style="display: flex; justify-content: space-between; color: var(--color-on-surface-variant);">
                        <span>{{ __('marketplace.order_detail_date') }}</span>
                        <span style="color: var(--color-on-surface);">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; color: var(--color-on-surface-variant);">
                        <span>{{ __('marketplace.order_detail_payment_method') }}</span>
                        <span style="color: var(--color-on-surface); text-transform: uppercase;">{{ $order->payment_method ? str_replace('_', ' ', $order->payment_method) : '-' }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; color: var(--color-on-surface-variant);">
                        <span>{{ __('marketplace.order_detail_payment_status') }}</span>
                        @php
                            $payBadge = match($order->payment_status) {
                                'paid' => 'badge-success',
                                'failed' => 'badge-danger',
                                'refunded' => 'badge-info',
                                default => 'badge-warning'
                            };
                            $payLabel = match($order->payment_status) {
                                'paid' => __('marketplace.dashboard_paid'),
                                'failed' => __('marketplace.dashboard_failed'),
                                'refunded' => __('marketplace.dashboard_refunded'),
                                default => __('marketplace.dashboard_unpaid')
                            };
                        @endphp
                        <span class="badge {{ $payBadge }}">{{ $payLabel }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; color: var(--color-on-surface-variant);">
                        <span>{{ __('marketplace.order_detail_order_status') }}</span>
                        @php
                            $statusBadge = match($order->status) {
                                'completed' => 'badge-success',
                                'processing' => 'badge-info',
                                'cancelled' => 'badge-danger',
                                default => 'badge-warning'
                            };
                        @endphp
                        <span class="badge {{ $statusBadge }}">{{ ucfirst($order->status) }}</span>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div style="display: flex; gap: 12px; margin-top: var(--space-4); justify-content: flex-end; flex-wrap: wrap;">
                <a href="{{ route('buyer.order.invoice', $order) }}" target="_blank" class="btn btn-secondary" style="padding: 10px 20px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    {{ __('marketplace.order_detail_invoice') }}
                </a>
                @if(in_array($order->status, ['pending', 'processing']))
                <div style="margin-top: var(--space-4); text-align: right;">
                    <form method="POST" action="{{ route('buyer.order.cancel', $order) }}" onsubmit="return confirm('{{ __('marketplace.order_detail_cancel_confirm') }}')">
                        @csrf
                        <button type="submit" class="btn btn-secondary" style="border-color: var(--color-error); color: var(--color-error); padding: 10px 20px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            {{ __('marketplace.order_detail_cancel') }}
                        </button>
                    </form>
                </div>
            @endif
            </div>

            {{-- Items --}}
            <div style="background: var(--color-surface-container); border: 1px solid var(--color-outline-variant); border-radius: var(--radius-lg); padding: var(--space-4); margin-top: var(--space-4);">
                <h3 style="font-family: var(--font-headline); font-size: 1.125rem; font-weight: 600; margin-bottom: var(--space-3);">{{ __('marketplace.order_detail_products') }}</h3>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @foreach($order->items as $item)
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid var(--color-outline-variant); {{ $loop->last ? 'border-bottom: none; padding-bottom: 0;' : '' }}">
                            <div>
                                <p style="font-weight: 600; color: var(--color-on-surface);">{{ $item->product?->name ?? __('marketplace.product_deleted') }}</p>
                                <p style="font-size: 0.75rem; color: var(--color-on-surface-variant);">x{{ $item->quantity }} &times; Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <span style="font-weight: 600; color: var(--color-primary);">Rp {{ number_format($item->total, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <div style="border-top: 1px solid var(--color-outline-variant); margin-top: 12px; padding-top: 12px; display: flex; flex-direction: column; gap: 8px; font-size: 0.875rem;">
                    <div style="display: flex; justify-content: space-between; color: var(--color-on-surface-variant);">
                        <span>{{ __('marketplace.order_detail_subtotal') }}</span>
                        <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @if($order->discount > 0)
                        <div style="display: flex; justify-content: space-between; color: var(--color-success);">
                            <span>{{ __('marketplace.order_detail_discount') }}</span>
                            <span>- Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div style="display: flex; justify-content: space-between; color: var(--color-on-surface-variant);">
                        <span>{{ __('marketplace.order_detail_unique_code') }}</span>
                        <span style="color: var(--color-warning);">+ Rp {{ number_format($order->unique_code, 0, ',', '.') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-weight: 700; font-size: 1rem; padding-top: 8px; border-top: 1px solid var(--color-outline-variant);">
                        <span style="color: var(--color-on-surface);">{{ __('marketplace.order_detail_total_transfer') }}</span>
                        <span style="color: var(--color-primary);">Rp {{ number_format($order->total_transfer, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
