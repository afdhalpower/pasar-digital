@extends('layouts.marketplace')

@section('title', 'Katalog Produk')

@section('content')
<section style="padding-top: 120px; padding-bottom: var(--space-4);">
    <div class="container">
        <h1 class="headline-md" style="margin-bottom: var(--space-2);">Katalog Produk</h1>
        <p class="body-md" style="color: var(--color-on-surface-variant);">Jelajahi koleksi produk digital terbaik dari kreator Indonesia</p>
    </div>
</section>

{{-- Filters --}}
<section style="padding-bottom: var(--space-5);">
    <div class="container">
        <form method="GET" action="{{ route('catalog.index') }}" style="display:flex; flex-wrap:wrap; gap:12px; align-items:center;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..." class="input-field" style="max-width:320px;">
            <select name="type" class="input-field" style="max-width:180px;" onchange="this.form.submit()">
                <option value="">Semua Tipe</option>
                <option value="digital" {{ request('type') == 'digital' ? 'selected' : '' }}>Digital</option>
                <option value="template" {{ request('type') == 'template' ? 'selected' : '' }}>Template</option>
                <option value="software" {{ request('type') == 'software' ? 'selected' : '' }}>Software</option>
                <option value="asset" {{ request('type') == 'asset' ? 'selected' : '' }}>Asset</option>
            </select>
            <select name="sort" class="input-field" style="max-width:180px;" onchange="this.form.submit()">
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Populer</option>
            </select>
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>

        {{-- Category chips --}}
        <div style="display:flex; flex-wrap:wrap; gap:8px; margin-top:16px;">
            <a href="{{ route('catalog.index', request()->except('category')) }}" class="chip chip-primary {{ !request('category') ? 'active' : '' }}">Semua</a>
            @foreach($categories as $cat)
                <a href="{{ route('catalog.index', array_merge(request()->except('category'), ['category' => $cat->slug])) }}"
                   class="chip chip-primary {{ request('category') == $cat->slug ? 'active' : '' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Products Grid --}}
<section class="section" style="padding-top:0;">
    <div class="container">
        <div class="grid-products">
            @forelse($products as $product)
                @include('components.product-card', ['product' => $product])
            @empty
                <div style="grid-column:1/-1; text-align:center; padding:80px 0;">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--color-outline)" stroke-width="1.5" style="margin-bottom:16px;"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    <h3 class="headline-sm" style="margin-bottom:8px;">Tidak ada produk ditemukan</h3>
                    <p class="body-md" style="color:var(--color-on-surface-variant);">Coba ubah filter atau kata kunci pencarian.</p>
                </div>
            @endforelse
        </div>

        @if($products->hasPages())
            <div style="display:flex; justify-content:center; margin-top:var(--space-6);">
                {{ $products->withQueryString()->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
