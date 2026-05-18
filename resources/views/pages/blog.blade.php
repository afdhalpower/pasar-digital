@extends('layouts.marketplace')

@section('title', 'Blog')
@section('meta_description', 'Artikel, tutorial, dan berita terbaru seputar produk digital dan kreativitas.')

@section('content')
<section class="section" style="padding-top:120px;">
    <div class="container">
        <div class="section-header">
            <div>
                <span class="hero-badge">Blog</span>
                <h1 class="headline-sm" style="margin-top:var(--space-2);">Artikel & Tutorial</h1>
                <p class="subtitle">Dapatkan inspirasi dan wawasan seputar dunia produk digital.</p>
            </div>
        </div>

        <div style="text-align:center; padding:var(--space-8) 0; color:var(--color-on-surface-variant);">
            <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)" stroke-width="1.2" style="margin-bottom:var(--space-3);">
                <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                <path d="M2 17l10 5 10-5"/>
                <path d="M2 12l10 5 10-5"/>
            </svg>
            <p class="body-lg">Belum ada artikel.</p>
            <p style="font-size:0.875rem;">Nantikan artikel menarik seputar produk digital, tutorial, dan tips kreatif.</p>
        </div>
    </div>
</section>
@endsection
