@extends('layouts.marketplace')

@section('title', 'Pesanan Berhasil')

@section('content')
<div class="container" style="padding-top: 120px; padding-bottom: var(--space-8); min-height: 85vh;">
    <div style="max-width: 600px; margin: 0 auto; text-align: center;">
        <div style="width: 80px; height: 80px; background: rgba(16, 185, 129, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto var(--space-4);">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--color-success)" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
        </div>

        <span class="label-sm" style="color: var(--color-success);">Pesanan Berhasil Dibuat</span>
        <h1 class="headline-md" style="margin-top: 8px;">Terima Kasih, {{ auth()->user()->name }}!</h1>
        <p style="color: var(--color-on-surface-variant); font-size: 0.875rem; margin-top: 8px; max-width: 400px; margin-left: auto; margin-right: auto;">
            Pesanan Anda telah tercatat. Silakan lakukan pembayaran sesuai instruksi di bawah untuk memproses pesanan.
        </p>

        <div style="background: var(--color-surface-container); border: 1px solid var(--color-outline-variant); border-radius: var(--radius-lg); padding: var(--space-4); margin-top: var(--space-5); text-align: left;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-3);">
                <h3 style="font-family: var(--font-headline); font-size: 1.125rem; font-weight: 600;">Detail Pesanan</h3>
                <span class="badge badge-warning">Menunggu Pembayaran</span>
            </div>

            <div style="display: flex; flex-direction: column; gap: 8px; font-size: 0.875rem;">
                <div style="display: flex; justify-content: space-between; color: var(--color-on-surface-variant);">
                    <span>No. Pesanan</span>
                    <span style="font-weight: 600; color: var(--color-on-surface);">{{ $order->order_number }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; color: var(--color-on-surface-variant);">
                    <span>Tanggal</span>
                    <span style="color: var(--color-on-surface);">{{ $order->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div style="border-top: 1px solid var(--color-outline-variant); margin: 8px 0;"></div>

                @foreach($order->items as $item)
                <div style="display: flex; justify-content: space-between; color: var(--color-on-surface-variant);">
                    <span>{{ $item->product->name }} <span style="font-size:0.8rem;">x{{ $item->quantity }}</span></span>
                    <span style="color: var(--color-on-surface);">Rp {{ number_format($item->total, 0, ',', '.') }}</span>
                </div>
                @endforeach

                <div style="border-top: 1px solid var(--color-outline-variant); margin: 8px 0;"></div>
                <div style="display: flex; justify-content: space-between; color: var(--color-on-surface-variant);">
                    <span>Kode Unik</span>
                    <span style="color: var(--color-warning); font-weight: 700;">+ Rp {{ number_format($order->unique_code, 0, ',', '.') }}</span>
                </div>
                <div style="border-top: 1px solid var(--color-outline-variant); margin: 8px 0;"></div>
                <div style="display: flex; justify-content: space-between; font-weight: 700;">
                    <span style="color: var(--color-on-surface);">Total Transfer</span>
                    <span style="color: var(--color-primary); font-size: 1.125rem;">Rp {{ number_format($order->total_transfer, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div style="background: rgba(245, 158, 11, 0.08); border: 1px solid rgba(245, 158, 11, 0.2); border-radius: var(--radius-lg); padding: var(--space-4); margin-top: var(--space-3); text-align: left;">
            <h4 style="font-size: 0.875rem; font-weight: 600; color: var(--color-warning); margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                Instruksi Pembayaran
            </h4>
            <p style="font-size: 0.8rem; color: var(--color-on-surface-variant); line-height: 1.6;">
                Silakan transfer <strong style="color: var(--color-on-surface);">tepat Rp {{ number_format($order->total_transfer, 0, ',', '.') }}</strong> (termasuk kode unik <strong style="color: var(--color-warning);">{{ $order->unique_code }}</strong>) ke rekening berikut:
            </p>
            <div style="background: var(--color-surface-container-high); border-radius: var(--radius-md); padding: 12px; margin-top: 10px;">
                <p style="font-size: 0.8rem; color: var(--color-on-surface-variant);">Bank BCA</p>
                <p style="font-size: 1rem; font-weight: 700; color: var(--color-on-surface); letter-spacing: 0.05em;">1234567890</p>
                <p style="font-size: 0.8rem; color: var(--color-on-surface-variant);">a.n. PT PublikDigital Indonesia</p>
            </div>
            <p style="font-size: 0.75rem; color: var(--color-on-surface-variant); margin-top: 10px;">
                Transfer harus <strong>tepat</strong> termasuk kode unik agar admin dapat memverifikasi pesanan dengan mudah. Konfirmasi pembayaran melalui <strong>Admin Panel</strong> setelah transfer.
            </p>
        </div>

        <div style="display: flex; gap: 12px; justify-content: center; margin-top: var(--space-5);">
            <a href="{{ route('buyer.orders') }}" class="btn btn-primary btn-pill" style="padding: 12px 28px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:6px;"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg>
                Lihat Pesanan Saya
            </a>
            <a href="{{ route('catalog.index') }}" class="btn btn-secondary btn-pill" style="padding: 12px 28px;">Lanjut Belanja</a>
        </div>
    </div>
</div>
@endsection
