@extends('layouts.marketplace')

@section('title', __('marketplace.careers_title'))
@section('meta_description', 'Bergabung dengan tim PublikDigital dan bangun karir di industri digital Indonesia.')

@section('content')
<section class="section" style="padding-top:120px;">
    <div class="container" style="text-align:center;">
        <span class="hero-badge">{{ __('marketplace.careers_badge') }}</span>
        <h1 class="display-lg hero-title">{{ __('marketplace.careers_heading') }}</h1>
        <p class="hero-subtitle" style="margin:0 auto var(--space-6); max-width:560px;">
            {{ __('marketplace.careers_hero') }}
        </p>

        <div style="background:var(--color-surface-container); border:1px solid var(--color-outline-variant); border-radius:var(--radius-lg); padding:var(--space-8); max-width:480px; margin:0 auto;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)" stroke-width="1.5" style="margin-bottom:var(--space-3);">
                <path d="M12 2a10 10 0 1 0 10 10h-10V2Z"/>
                <path d="M12 2v10h10A10 10 0 0 0 12 2Z"/>
                <path d="M12 12 7 7"/>
                <path d="M12 12 7 17"/>
                <path d="M12 12 17 7"/>
                <path d="M12 12 17 17"/>
            </svg>
            <p class="body-lg" style="color:var(--color-on-surface-variant);">
                {{ __('marketplace.careers_empty') }}
            </p>
            <p style="color:var(--color-outline); font-size:0.875rem; margin-top:var(--space-2);">
                {{ __('marketplace.careers_empty_text') }}
            </p>
        </div>
    </div>
</section>
@endsection
