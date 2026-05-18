@extends('layouts.marketplace')

@section('title', 'Produk Favorit')

@section('content')
<div class="container" style="padding-top: 120px; padding-bottom: var(--space-8); min-height: 85vh;">
    <div style="display: grid; grid-template-columns: 280px 1fr; gap: var(--space-5);" class="dashboard-grid">
        @include('buyer.sidebar')

        <main class="dashboard-content-area animate-in">
            <div style="margin-bottom: var(--space-4);">
                <span class="label-sm" style="color: var(--color-primary);">Favorit Anda</span>
                <h1 class="headline-md" style="margin-top: 4px;">Produk Favorit</h1>
                <p style="color: var(--color-on-surface-variant); font-size: 0.875rem;">Produk yang Anda tandai sebagai favorit.</p>
            </div>

            <div class="grid-products">
                @forelse($products as $product)
                    @include('components.product-card', ['product' => $product])
                @empty
                    <div style="grid-column: 1/-1; text-align: center; padding: 80px 0; background: var(--color-surface-container); border: 1px solid var(--color-outline-variant); border-radius: var(--radius-lg);">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--color-outline)" stroke-width="1.5" style="margin-bottom:16px;"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                        <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--color-on-surface); margin-bottom: 8px;">Belum ada produk favorit</h3>
                        <p style="color: var(--color-on-surface-variant); font-size: 0.875rem; margin-bottom: 20px;">Anda belum menambahkan produk favorit. Jelajahi katalog dan klik ikon hati untuk menyimpan favorit.</p>
                        <a href="{{ route('catalog.index') }}" class="btn btn-primary" style="padding: 8px 20px; font-size: 0.875rem;">Jelajahi Katalog</a>
                    </div>
                @endforelse
            </div>

            @if($products->hasPages())
                <div style="display:flex; justify-content:center; margin-top:var(--space-6);">
                    {{ $products->withQueryString()->links() }}
                </div>
            @endif
        </main>
    </div>
</div>
@endsection
