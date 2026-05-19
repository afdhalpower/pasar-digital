@extends('layouts.marketplace')

@section('title', 'Riwayat Pesanan')

@php $hasFilter = request()->anyFilled(['search', 'payment', 'status']); @endphp

@section('content')
<div class="container" style="padding-top: 120px; padding-bottom: var(--space-8); min-height: 85vh;">
    <div style="display: grid; grid-template-columns: 280px 1fr; gap: var(--space-5);" class="dashboard-grid">
        @include('buyer.sidebar')

        <main class="dashboard-content-area animate-in">
            <div style="margin-bottom: var(--space-4);">
                <span class="label-sm" style="color: var(--color-primary);">Transaksi Anda</span>
                <h1 class="headline-md" style="margin-top: 4px;">Riwayat Pesanan</h1>
                <p style="color: var(--color-on-surface-variant); font-size: 0.875rem;">Semua riwayat transaksi pembelian produk digital Anda.</p>
            </div>

            <form method="GET" action="{{ route('buyer.orders') }}" style="display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: var(--space-4);">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari no. pesanan..." class="input-field" style="max-width: 260px;">
                <select name="payment" class="input-field" style="max-width: 160px;" onchange="this.form.submit()">
                    <option value="">Semua Pembayaran</option>
                    <option value="paid" {{ request('payment') == 'paid' ? 'selected' : '' }}>Lunas</option>
                    <option value="unpaid" {{ request('payment') == 'unpaid' ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="failed" {{ request('payment') == 'failed' ? 'selected' : '' }}>Gagal</option>
                    <option value="refunded" {{ request('payment') == 'refunded' ? 'selected' : '' }}>Refund</option>
                </select>
                <select name="status" class="input-field" style="max-width: 160px;" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Batal</option>
                </select>
                <button type="submit" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.8rem;">Filter</button>
                @if($hasFilter)
                    <a href="{{ route('buyer.orders') }}" class="btn btn-secondary" style="padding: 8px 16px; font-size: 0.8rem;">Reset</a>
                @endif
            </form>

            <div style="background: var(--color-surface-container); border: 1px solid var(--color-outline-variant); border-radius: var(--radius-lg); padding: var(--space-4);">
                <div style="overflow-x: auto;">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Tanggal</th>
                                <th>Metode Pembayaran</th>
                                <th>Total</th>
                                <th>Status Pembayaran</th>
                                <th>Status Pesanan</th>
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
                                            <span class="badge badge-success">Lunas</span>
                                        @elseif ($order->payment_status === 'failed')
                                            <span class="badge badge-danger">Gagal</span>
                                        @elseif ($order->payment_status === 'refunded')
                                            <span class="badge badge-info">Refunded</span>
                                        @else
                                            <span class="badge badge-warning">Belum Bayar</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($order->status === 'completed')
                                            <span class="badge badge-success">Selesai</span>
                                        @elseif ($order->status === 'pending')
                                            <span class="badge badge-warning">Menunggu</span>
                                        @elseif ($order->status === 'processing')
                                            <span class="badge badge-info">Diproses</span>
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
                                                Tidak ada pesanan dengan filter tersebut
                                            @else
                                                Belum ada pesanan
                                            @endif
                                        </h3>
                                        <p style="color: var(--color-on-surface-variant); font-size: 0.875rem; margin-bottom: 20px;">
                                            @if($hasFilter)
                                                Coba ubah filter atau kata kunci pencarian.
                                            @else
                                                Anda belum melakukan pembelian produk apapun di RepublikDigital.
                                            @endif
                                        </p>
                                        @unless($hasFilter)
                                            <a href="{{ route('catalog.index') }}" class="btn btn-primary" style="padding: 8px 20px; font-size: 0.875rem;">Mulai Belanja</a>
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
