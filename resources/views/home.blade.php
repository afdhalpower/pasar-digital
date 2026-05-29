@extends('layouts.marketplace')

@section('title', __('marketplace.nav_home'))

@section('content')
{{-- Hero Section --}}
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <span class="hero-badge animate-in">✨ {{ __('marketplace.home_hero_badge') }}</span>
            <h1 class="display-lg hero-title animate-in animate-delay-1">
                {{ __('marketplace.home_hero_heading') }}
            </h1>
            <p class="hero-subtitle animate-in animate-delay-2">
                {{ __('marketplace.home_hero_subtitle') }}
            </p>
            <div class="hero-actions animate-in animate-delay-3">
                <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-lg btn-pill">
                    {{ __('marketplace.home_hero_cta') }}
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="#featured" class="btn btn-secondary btn-lg btn-pill">{{ __('marketplace.home_featured_heading') }}</a>
            </div>

            <div class="stats-bar animate-in animate-delay-3">
                <div class="stat-item">
                    <div class="stat-value">500+</div>
                    <div class="stat-label">{{ __('marketplace.home_stat_products') }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">2.5K+</div>
                    <div class="stat-label">{{ __('marketplace.home_stat_creators') }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">10K+</div>
                    <div class="stat-label">{{ __('marketplace.home_stat_downloads') }}</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Categories Section --}}
<section class="section" style="background: var(--color-surface-container-lowest);">
    <div class="container">
        <div class="section-header">
            <div>
                <h2 class="headline-md">{{ __('marketplace.home_categories_heading') }}</h2>
                <p class="subtitle body-md">{{ __('marketplace.home_categories_subtitle') }}</p>
            </div>
        </div>
        <div style="display:flex; flex-wrap:wrap; gap:12px;">
            @forelse($categories as $cat)
                <a href="{{ route('catalog.index', ['category' => $cat->slug]) }}" class="chip chip-primary">
                    {{ $cat->name }}
                    <span style="margin-left:6px; opacity:0.7;">({{ $cat->active_products_count }})</span>
                </a>
            @empty
                <p style="color: var(--color-on-surface-variant);">{!! str_replace('Admin Panel', '<a href="/admin" style="color:var(--color-primary);">Admin Panel</a>', __('marketplace.home_categories_empty')) !!}</p>
            @endforelse
        </div>
    </div>
</section>

{{-- Featured Products --}}
<section class="section" id="featured">
    <div class="container">
        <div class="section-header">
            <div>
                <h2 class="headline-md">{{ __('marketplace.home_featured_heading') }}</h2>
                <p class="subtitle body-md">{{ __('marketplace.home_featured_subtitle') }}</p>
            </div>
            <a href="{{ route('catalog.index') }}" class="btn btn-secondary btn-pill">{{ __('marketplace.home_featured_view_all') }}</a>
        </div>
        <div class="grid-products">
            @forelse($featuredProducts as $product)
                @include('components.product-card', ['product' => $product])
            @empty
                <p style="color: var(--color-on-surface-variant); grid-column: 1/-1; text-align:center; padding: 60px 0;">
                    {!! str_replace('Admin Panel', '<a href="/admin" style="color:var(--color-primary);">Admin Panel</a>', __('marketplace.home_featured_empty')) !!}
                </p>
            @endforelse
        </div>
    </div>
</section>

{{-- Latest Products --}}
<section class="section" style="background: var(--color-surface-container-lowest);">
    <div class="container">
        <div class="section-header">
            <div>
                <h2 class="headline-md">{{ __('marketplace.home_latest_heading') }}</h2>
                <p class="subtitle body-md">{{ __('marketplace.home_latest_subtitle') }}</p>
            </div>
            <a href="{{ route('catalog.index', ['sort' => 'latest']) }}" class="btn btn-secondary btn-pill">{{ __('marketplace.home_featured_view_all') }}</a>
        </div>
        <div class="grid-products">
            @forelse($latestProducts as $product)
                @include('components.product-card', ['product' => $product])
            @empty
                <p style="color: var(--color-on-surface-variant); grid-column: 1/-1; text-align:center; padding: 60px 0;">
                    {!! str_replace('Admin Panel', '<a href="/admin" style="color:var(--color-primary);">Admin Panel</a>', __('marketplace.home_latest_empty')) !!}
                </p>
            @endforelse
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="section-lg" style="text-align:center;">
    <div class="container">
        <h2 class="headline-md" style="margin-bottom: var(--space-2);">{{ __('marketplace.home_cta_heading') }}</h2>
        <p class="body-lg" style="color: var(--color-on-surface-variant); max-width: 500px; margin: 0 auto var(--space-4);">
            {{ __('marketplace.home_cta_text') }}
        </p>
        <a href="{{ url('/admin/register') }}" class="btn btn-primary btn-lg btn-pill">{{ __('marketplace.home_cta_button') }}</a>
    </div>
</section>
@endsection
