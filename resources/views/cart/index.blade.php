@extends('layouts.marketplace')

@section('title', __('marketplace.cart_title'))

@push('styles')
<style>
.cart-item {
    display: flex;
    align-items: center;
    gap: var(--space-4);
    padding: var(--space-3);
    background: var(--color-surface-container);
    border: 1px solid var(--color-outline-variant);
    border-radius: var(--radius-lg);
    transition: all 0.3s ease;
}
.cart-item:hover {
    border-color: rgba(107, 216, 203, 0.3);
}
.cart-item-img {
    width: 100px;
    height: 75px;
    border-radius: var(--radius-md);
    object-fit: cover;
    flex-shrink: 0;
    background: var(--color-surface-container-high);
}
.cart-item-body {
    flex: 1;
    min-width: 0;
}
.cart-item-title {
    font-family: var(--font-headline);
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--color-on-surface);
    margin-bottom: 4px;
}
.cart-item-category {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--color-primary);
}
.cart-item-price {
    font-size: 1rem;
    font-weight: 700;
    color: var(--color-primary);
    white-space: nowrap;
}
.qty-input {
    width: 64px;
    padding: 6px 10px;
    background: var(--color-surface-container-high);
    border: 1px solid var(--color-outline-variant);
    border-radius: var(--radius-md);
    color: var(--color-on-surface);
    font-size: 0.875rem;
    text-align: center;
}
.qty-input:focus {
    outline: none;
    border-color: var(--color-primary);
}
.cart-summary {
    background: var(--color-surface-container);
    border: 1px solid var(--color-outline-variant);
    border-radius: var(--radius-lg);
    padding: var(--space-4);
    position: sticky;
    top: 100px;
}
.cart-summary-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    font-size: 0.875rem;
    color: var(--color-on-surface-variant);
}
.cart-summary-row.total {
    border-top: 1px solid var(--color-outline-variant);
    margin-top: 8px;
    padding-top: 16px;
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--color-on-surface);
}
.cart-summary-row.total span:last-child {
    color: var(--color-primary);
}
</style>
@endpush

@section('content')
<div class="container" style="padding-top: 120px; padding-bottom: var(--space-8); min-height: 85vh;">
    <div style="margin-bottom: var(--space-4);">
        <span class="label-sm" style="color: var(--color-primary);">{{ __('marketplace.cart_badge') }}</span>
        <h1 class="headline-md" style="margin-top: 4px;">{{ __('marketplace.cart_title') }}</h1>
        <p style="color: var(--color-on-surface-variant); font-size: 0.875rem;">{{ __('marketplace.cart_item_count', ['count' => $cartItems->count()]) }}</p>
    </div>

    @if (session('success'))
        <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: var(--color-success); padding: 12px 16px; border-radius: var(--radius-md); font-size: 0.875rem; margin-bottom: var(--space-3); display: flex; align-items: center; gap: 8px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div style="background: rgba(255, 180, 171, 0.1); border: 1px solid var(--color-error); color: var(--color-error); padding: 12px 16px; border-radius: var(--radius-md); font-size: 0.875rem; margin-bottom: var(--space-3);">
            {{ session('error') }}
        </div>
    @endif

    @if($cartItems->isEmpty())
        <div style="text-align: center; padding: 80px 0; background: var(--color-surface-container); border: 1px solid var(--color-outline-variant); border-radius: var(--radius-lg);">
            <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="var(--color-outline)" stroke-width="1.5" style="margin-bottom: 16px;">
                <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--color-on-surface); margin-bottom: 8px;">{{ __('marketplace.cart_empty_heading') }}</h3>
            <p style="color: var(--color-on-surface-variant); font-size: 0.875rem; margin-bottom: 20px;">{{ __('marketplace.cart_empty_text') }}</p>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-pill" style="padding: 10px 24px;">{{ __('marketplace.cart_empty_cta') }}</a>
        </div>
    @else
        <div style="display: grid; grid-template-columns: 1fr 360px; gap: var(--space-5); align-items: start;">
            <div style="display: flex; flex-direction: column; gap: var(--space-3);">
                @foreach($cartItems as $item)
                    <div class="cart-item">
                        @if($item->product->getThumbnailUrl())
                            <img src="{{ $item->product->getThumbnailUrl() }}" alt="{{ $item->product->name }}" class="cart-item-img">
                        @else
                            <div class="cart-item-img" style="display:flex; align-items:center; justify-content:center; color:var(--color-outline);">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                            </div>
                        @endif
                        <div class="cart-item-body">
                            <a href="{{ route('catalog.show', $item->product->slug) }}" class="cart-item-title" style="text-decoration:none;">{{ $item->product->name }}</a>
                            <div class="cart-item-category" style="margin-bottom:6px;">{{ $item->product->category->name ?? __('marketplace.product_uncategorized') }}</div>
                            <div class="cart-item-price">Rp {{ number_format($item->product->effective_price, 0, ',', '.') }}</div>
                        </div>
                        <form action="{{ route('cart.update', $item) }}" method="POST" style="display:flex; align-items:center; gap:8px;">
                            @csrf
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="99" class="qty-input" onchange="this.form.submit()">
                        </form>
                        <div style="font-size: 1rem; font-weight: 700; color: var(--color-primary); min-width:80px; text-align:right;">
                            Rp {{ number_format($item->product->effective_price * $item->quantity, 0, ',', '.') }}
                        </div>
                        <form action="{{ route('cart.remove', $item) }}" method="POST" style="margin:0;">
                            @csrf
                            <button type="submit" style="background:none; border:none; cursor:pointer; color:var(--color-error); padding:4px;" title="{{ __('marketplace.cart_remove') }}">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="cart-summary">
                <h3 style="font-family:var(--font-headline); font-size:1.25rem; font-weight:600; margin-bottom:var(--space-3);">{{ __('marketplace.cart_summary') }}</h3>
                @php
                    $subtotal = $cartItems->sum(fn ($i) => $i->product->effective_price * $i->quantity);
                    $appliedCoupon = session('applied_coupon') ? \App\Models\Coupon::find(session('applied_coupon')) : null;
                    $discount = $appliedCoupon ? $appliedCoupon->calculateDiscount($subtotal) : 0;
                @endphp
                <div class="cart-summary-row">
                    <span>{{ __('marketplace.cart_subtotal', ['count' => $cartItems->sum('quantity')]) }}</span>
                    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>

                {{-- Coupon --}}
                <div style="border-top: 1px solid var(--color-outline-variant); padding-top: 12px; margin-top: 8px;">
                    @if($appliedCoupon)
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                            <div>
                                <span style="font-size:0.8rem; font-weight:600; color:var(--color-success);">{{ __('marketplace.cart_coupon') }} {{ $appliedCoupon->code }}</span>
                                <span style="font-size:0.75rem; color:var(--color-on-surface-variant); display:block;">{{ $appliedCoupon->name }}</span>
                            </div>
                            <form action="{{ route('cart.coupon.remove') }}" method="POST" style="margin:0;">
                                @csrf
                                <button type="submit" style="background:none; border:none; cursor:pointer; color:var(--color-error); font-size:0.75rem;">{{ __('marketplace.cart_remove_coupon') }}</button>
                            </form>
                        </div>
                    @else
                        <form action="{{ route('cart.coupon.apply') }}" method="POST" style="display:flex; gap:8px;">
                            @csrf
                            <input type="text" name="code" placeholder="{{ __('marketplace.cart_coupon_placeholder') }}" style="flex:1; padding:8px 12px; background:var(--color-surface-container-high); border:1px solid var(--color-outline-variant); border-radius:var(--radius-md); color:var(--color-on-surface); font-size:0.8rem;">
                            <button type="submit" class="btn btn-primary" style="padding:8px 12px; font-size:0.75rem;">{{ __('marketplace.cart_apply_coupon') }}</button>
                        </form>
                    @endif
                </div>

                <div class="cart-summary-row">
                    <span>{{ __('marketplace.cart_tax') }}</span>
                    <span>Rp 0</span>
                </div>
                @if($discount > 0)
                    <div class="cart-summary-row" style="color: var(--color-success);">
                        <span>{{ __('marketplace.cart_discount') }}</span>
                        <span>- Rp {{ number_format($discount, 0, ',', '.') }}</span>
                    </div>
                @endif
                <div class="cart-summary-row total">
                    <span>{{ __('marketplace.cart_total') }}</span>
                    <span>Rp {{ number_format(max($subtotal - $discount, 0), 0, ',', '.') }}</span>
                </div>
                <form action="{{ route('cart.checkout') }}" method="POST" style="margin-top:var(--space-3);">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="width:100%; padding:14px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:6px;"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg>
                        {{ __('marketplace.cart_checkout') }}
                    </button>
                </form>
                <div style="text-align:center; margin-top:12px;">
                    <a href="{{ route('catalog.index') }}" style="color:var(--color-on-surface-variant); font-size:0.8rem;">{{ __('marketplace.cart_continue') }}</a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
