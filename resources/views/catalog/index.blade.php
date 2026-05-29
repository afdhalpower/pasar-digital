@extends('layouts.marketplace')

@section('title', __('marketplace.catalog_title'))

@section('content')
<section style="padding-top: 120px; padding-bottom: var(--space-4);">
    <div class="container">
        <h1 class="headline-md" style="margin-bottom: var(--space-2);">{{ __('marketplace.catalog_title') }}</h1>
        <p class="body-md" style="color: var(--color-on-surface-variant);">{{ __('marketplace.catalog_subtitle') }}</p>
    </div>
</section>

{{-- Filters --}}
<section style="padding-bottom: var(--space-5);">
    <div class="container">
        <form method="GET" action="{{ route('catalog.index') }}" style="display:flex; flex-wrap:wrap; gap:12px; align-items:center;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('marketplace.catalog_search_placeholder') }}" class="input-field" style="max-width:320px;">
            <select name="type" class="input-field" style="max-width:180px;" onchange="this.form.submit()">
                <option value="">{{ __('marketplace.catalog_all_types') }}</option>
                <option value="digital" {{ request('type') == 'digital' ? 'selected' : '' }}>{{ __('marketplace.catalog_type_digital') }}</option>
                <option value="template" {{ request('type') == 'template' ? 'selected' : '' }}>{{ __('marketplace.catalog_type_template') }}</option>
                <option value="software" {{ request('type') == 'software' ? 'selected' : '' }}>{{ __('marketplace.catalog_type_software') }}</option>
                <option value="asset" {{ request('type') == 'asset' ? 'selected' : '' }}>{{ __('marketplace.catalog_type_asset') }}</option>
            </select>
            <select name="sort" class="input-field" style="max-width:180px;" onchange="this.form.submit()">
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>{{ __('marketplace.catalog_sort_newest') }}</option>
                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>{{ __('marketplace.catalog_sort_price_low') }}</option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>{{ __('marketplace.catalog_sort_price_high') }}</option>
                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>{{ __('marketplace.catalog_sort_popular') }}</option>
            </select>
            <button type="submit" class="btn btn-primary">{{ __('marketplace.catalog_search_button') }}</button>
        </form>

        {{-- Category chips --}}
        <div style="display:flex; flex-wrap:wrap; gap:8px; margin-top:16px;">
            <a href="{{ route('catalog.index', request()->except('category')) }}" class="chip chip-primary {{ !request('category') ? 'active' : '' }}">{{ __('marketplace.catalog_all') }}</a>
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
                    <h3 class="headline-sm" style="margin-bottom:8px;">{{ __('marketplace.catalog_empty_heading') }}</h3>
                    <p class="body-md" style="color:var(--color-on-surface-variant);">{{ __('marketplace.catalog_empty_text') }}</p>
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
