@extends('layouts.marketplace')

@section('title', __('marketplace.blog_title'))
@section('meta_description', 'Artikel, tutorial, dan berita terbaru seputar produk digital dan kreativitas.')

@section('content')
<section class="section" style="padding-top:120px;">
    <div class="container">
        <div class="section-header">
            <div>
                <span class="hero-badge">{{ __('marketplace.blog_badge') }}</span>
                <h1 class="headline-sm" style="margin-top:var(--space-2);">{{ __('marketplace.blog_heading') }}</h1>
                <p class="subtitle">{{ __('marketplace.blog_subtitle') }}</p>
            </div>
        </div>

        <div style="text-align:center; padding:var(--space-8) 0; color:var(--color-on-surface-variant);">
            <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)" stroke-width="1.2" style="margin-bottom:var(--space-3);">
                <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                <path d="M2 17l10 5 10-5"/>
                <path d="M2 12l10 5 10-5"/>
            </svg>
            <p class="body-lg">{{ __('marketplace.blog_empty') }}</p>
            <p style="font-size:0.875rem;">{{ __('marketplace.blog_empty_text') }}</p>
        </div>
    </div>
</section>
@endsection
