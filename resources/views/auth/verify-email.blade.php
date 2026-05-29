@extends('layouts.marketplace')

@section('title', __('auth.verify_title'))

@section('content')
<section class="section" style="padding-top:120px;">
    <div class="container" style="max-width:520px;">
        <div style="text-align:center; margin-bottom:var(--space-6);">
            <div style="width:64px; height:64px; border-radius:50%; background:rgba(107,216,203,0.1); display:flex; align-items:center; justify-content:center; margin:0 auto var(--space-3);">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)" stroke-width="2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>
            </div>
            <h1 class="headline-md" style="margin-bottom:var(--space-1);">{{ __('auth.verify_heading') }}</h1>
            <p class="hero-subtitle" style="margin:var(--space-1) auto 0; font-size:0.9rem;">
                {{ __('auth.verify_info', ['email' => auth()->user()->email]) }}
            </p>
        </div>

        @if(session('success'))
            <div style="background:rgba(16,185,129,0.1); border:1px solid var(--color-success); border-radius:var(--radius-md); padding:var(--space-3); margin-bottom:var(--space-4); text-align:center;">
                <p style="color:var(--color-success); font-size:0.875rem;">{{ session('success') }}</p>
            </div>
        @endif

        <div style="background:var(--color-surface-container); border:1px solid var(--color-outline-variant); border-radius:var(--radius-lg); padding:var(--space-4); text-align:center;">
            <p style="font-size:0.875rem; color:var(--color-on-surface-variant); margin-bottom:var(--space-4);">
                {{ __('auth.verify_prompt') }}
            </p>

            <form action="{{ route('verification.send') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary btn-pill" style="width:100%;">
                    {{ __('auth.verify_resend') }}
                </button>
            </form>

            <div style="margin-top:var(--space-3);">
                <form action="{{ route('buyer.logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="background:none; border:none; color:var(--color-on-surface-variant); font-size:0.8rem; cursor:pointer; text-decoration:underline;">
                        {{ __('auth.verify_logout') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
