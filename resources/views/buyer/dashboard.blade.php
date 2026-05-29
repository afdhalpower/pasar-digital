@extends('layouts.marketplace')

@section('title', __('marketplace.dashboard_title'))



@section('content')
<div class="container" style="padding-top: 120px; padding-bottom: var(--space-8); min-height: 85vh;">
    <div style="display: grid; grid-template-columns: 280px 1fr; gap: var(--space-5);" class="dashboard-grid">
        
        {{-- Sidebar --}}
        @include('buyer.sidebar')

        {{-- Main Dashboard Content --}}
        <main class="dashboard-content-area animate-in">
            <div style="margin-bottom: var(--space-4);">
                <span class="label-sm" style="color: var(--color-primary);">{{ __('marketplace.dashboard_badge') }}</span>
                <h1 class="headline-md" style="margin-top: 4px;">{{ __('marketplace.dashboard_greeting', ['name' => auth()->user()->name]) }}</h1>
                <p style="color: var(--color-on-surface-variant); font-size: 0.875rem;">{{ __('marketplace.dashboard_subtitle') }}</p>
            </div>

            {{-- Metrics Grid --}}
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: var(--space-3); margin-bottom: var(--space-5);">
                <div class="metric-card">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <span style="font-size: 0.875rem; color: var(--color-on-surface-variant); font-weight: 500;">{{ __('marketplace.dashboard_total_spent') }}</span>
                        <div style="color: var(--color-primary); background: rgba(107, 216, 203, 0.1); padding: 8px; border-radius: var(--radius-md);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><line x1="12" y1="10" x2="12" y2="10"/><path d="M8 10h.01M16 10h.01"/></svg>
                        </div>
                    </div>
                    <h2 class="headline-sm" style="color: var(--color-primary); font-size: 1.5rem;">Rp {{ number_format($totalSpent, 0, ',', '.') }}</h2>
                    <span style="font-size: 0.75rem; color: var(--color-on-surface-variant);">{{ __('marketplace.dashboard_spent_subtitle') }}</span>
                </div>

                <div class="metric-card">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <span style="font-size: 0.875rem; color: var(--color-on-surface-variant); font-weight: 500;">{{ __('marketplace.dashboard_active_orders') }}</span>
                        <div style="color: var(--color-warning); background: rgba(245, 158, 11, 0.1); padding: 8px; border-radius: var(--radius-md);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                    </div>
                    <h2 class="headline-sm" style="color: var(--color-on-surface); font-size: 1.5rem;">{{ $activeOrdersCount }}</h2>
                    <span style="font-size: 0.75rem; color: var(--color-on-surface-variant);">{{ __('marketplace.dashboard_active_subtitle') }}</span>
                </div>

                <div class="metric-card">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <span style="font-size: 0.875rem; color: var(--color-on-surface-variant); font-weight: 500;">{{ __('marketplace.dashboard_total_products') }}</span>
                        <div style="color: var(--color-success); background: rgba(16, 185, 129, 0.1); padding: 8px; border-radius: var(--radius-md);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                        </div>
                    </div>
                    <h2 class="headline-sm" style="color: var(--color-success); font-size: 1.5rem;">{{ $totalDownloadsCount }}</h2>
                    <span style="font-size: 0.75rem; color: var(--color-on-surface-variant);">{{ __('marketplace.dashboard_total_products_subtitle') }}</span>
                </div>
            </div>

            {{-- Recent Orders Section --}}
            <div style="background: var(--color-surface-container); border: 1px solid var(--color-outline-variant); border-radius: var(--radius-lg); padding: var(--space-4); margin-bottom: var(--space-5);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <h3 class="headline-sm" style="font-size: 1.25rem;">{{ __('marketplace.dashboard_recent_orders') }}</h3>
                    <a href="{{ route('buyer.orders') }}" style="color: var(--color-primary); font-size: 0.875rem; font-weight: 600; text-decoration: none;">{{ __('marketplace.dashboard_view_all') }}</a>
                </div>
                
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
                            @forelse ($recentOrders as $order)
                                <tr>
                                    <td style="font-weight: 600; color: var(--color-on-surface);">{{ $order->order_number }}</td>
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
                                    <td colspan="6" style="text-align: center; padding: 40px 0; color: var(--color-on-surface-variant);">
                                        {{ __('marketplace.dashboard_orders_empty') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Recent Downloads Section --}}
            <div style="background: var(--color-surface-container); border: 1px solid var(--color-outline-variant); border-radius: var(--radius-lg); padding: var(--space-4);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <h3 class="headline-sm" style="font-size: 1.25rem;">{{ __('marketplace.dashboard_recent_downloads') }}</h3>
                    <a href="{{ route('buyer.downloads') }}" style="color: var(--color-primary); font-size: 0.875rem; font-weight: 600; text-decoration: none;">{{ __('marketplace.dashboard_view_all') }}</a>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 16px;">
                    @forelse ($recentDownloads as $item)
                        @if ($item->product)
                            <div style="background: var(--color-surface-container-high); border: 1px solid var(--color-outline-variant); border-radius: var(--radius-md); padding: 16px; display: flex; flex-direction: column; justify-content: space-between; height: 160px; transition: all 0.3s;" onmouseover="this.style.borderColor='var(--color-primary)'" onmouseout="this.style.borderColor='var(--color-outline-variant)'">
                                <div>
                                    <span style="font-size: 0.75rem; color: var(--color-primary); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">{{ $item->product->type }}</span>
                                    <h4 style="font-size: 1rem; font-weight: 600; color: var(--color-on-surface); margin-top: 4px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; max-height: 2.8em;">
                                        {{ $item->product->name }}
                                    </h4>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 12px;">
                                    <span style="font-size: 0.75rem; color: var(--color-on-surface-variant);">{{ __('marketplace.dashboard_download_date_prefix') }} {{ $item->created_at->format('d/m/y') }}</span>
                                    <a href="{{ route('buyer.download-file', $item->product) }}" class="btn btn-primary" style="padding: 6px 12px; font-size: 0.75rem; border-radius: var(--radius-md);">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 4px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                                        {{ __('marketplace.dashboard_download') }}
                                    </a>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div style="grid-column: 1/-1; text-align: center; padding: 30px 0; color: var(--color-on-surface-variant); font-size: 0.875rem;">
                            {{ __('marketplace.dashboard_downloads_empty') }}
                        </div>
                    @endforelse
                </div>
            </div>

        </main>

    </div>
</div>
@endsection
