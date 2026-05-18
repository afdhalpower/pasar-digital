@extends('layouts.marketplace')

@section('title', 'Karir')
@section('meta_description', 'Bergabung dengan tim PublikDigital dan bangun karir di industri digital Indonesia.')

@section('content')
<section class="section" style="padding-top:120px;">
    <div class="container" style="text-align:center;">
        <span class="hero-badge">Karir</span>
        <h1 class="display-lg hero-title">Bergabung dengan Kami</h1>
        <p class="hero-subtitle" style="margin:0 auto var(--space-6); max-width:560px;">
            Kami sedang membangun tim impian. Jika kamu bersemangat dalam industri digital dan ingin berdampak, kami tunggu aplikasimu.
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
                Belum ada lowongan terbuka saat ini.
            </p>
            <p style="color:var(--color-outline); font-size:0.875rem; margin-top:var(--space-2);">
                Pantau terus halaman ini untuk informasi terbaru.
            </p>
        </div>
    </div>
</section>
@endsection
