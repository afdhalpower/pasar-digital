@extends('layouts.marketplace')

@section('title', __('marketplace.bundles_title'))

@section('content')
<section style="padding-top: 120px; padding-bottom: var(--space-4);">
    <div class="container">
        <h1 class="headline-md" style="margin-bottom: var(--space-2);">{{ __('marketplace.bundles_heading') }}</h1>
        <p class="body-md" style="color: var(--color-on-surface-variant);">{{ __('marketplace.bundles_subtitle') }}</p>
    </div>
</section>

<section class="section" style="padding-top:0;">
    <div class="container">
        @forelse($bundles as $bundle)
            <div class="bundle-card" style="background: var(--color-surface-container-high); border: 1px solid var(--color-outline-variant); border-radius: var(--radius-xl); padding: var(--space-5); margin-bottom: var(--space-5);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: var(--space-4);">
                    <div style="flex: 1; min-width: 200px;">
                        <h2 class="headline-sm" style="margin-bottom: 4px;">{{ $bundle->name }}</h2>
                        @if($bundle->description)
                            <p class="body-md" style="color: var(--color-on-surface-variant); margin-bottom: var(--space-3);">{{ $bundle->description }}</p>
                        @endif
                        <div style="display: flex; align-items: center; gap: var(--space-3); flex-wrap: wrap;">
                            <span style="font-size: 1.5rem; font-weight: 700; color: var(--color-primary);">Rp{{ number_format($bundle->price, 0, ',', '.') }}</span>
                            <span style="font-size: 0.9rem; color: var(--color-on-surface-variant); text-decoration: line-through;">Rp{{ number_format($bundle->totalOriginalPrice(), 0, ',', '.') }}</span>
                            <span class="chip chip-success">{{ __('marketplace.bundles_discount', ['discount' => $bundle->discountPercentage()]) }}</span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('cart.index') }}" style="display:none;">
                        @csrf
                        {{-- TODO: add-to-cart for bundles --}}
                    </form>
                </div>

                @if($bundle->products->isNotEmpty())
                    <div style="margin-top: var(--space-4); padding-top: var(--space-4); border-top: 1px solid var(--color-outline-variant);">
                        <p class="body-sm" style="font-weight: 600; color: var(--color-on-surface); margin-bottom: var(--space-2);">{{ __('marketplace.bundles_includes') }}</p>
                        <div style="display: flex; flex-wrap: wrap; gap: var(--space-2);">
                            @foreach($bundle->products as $product)
                                <a href="{{ route('catalog.show', $product->slug) }}" style="display: flex; align-items: center; gap: 6px; background: var(--color-surface-container); padding: 6px 12px; border-radius: var(--radius-full); text-decoration: none; font-size: 0.8rem; color: var(--color-on-surface-variant);">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                                    {{ $product->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div style="text-align:center; padding:80px 0;">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--color-outline)" stroke-width="1.5" style="margin-bottom:16px;"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8"/><path d="M12 17v4"/></svg>
                <h3 class="headline-sm" style="margin-bottom:8px;">{{ __('marketplace.bundles_empty_heading') }}</h3>
                <p class="body-md" style="color:var(--color-on-surface-variant);">{{ __('marketplace.bundles_empty_text') }}</p>
            </div>
        @endforelse

        @if($bundles->hasPages())
            <div style="display:flex; justify-content:center; margin-top:var(--space-6);">
                {{ $bundles->withQueryString()->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
