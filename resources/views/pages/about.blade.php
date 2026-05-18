@extends('layouts.marketplace')

@section('title', 'Tentang Kami')
@section('meta_description', 'Pelajari lebih lanjut tentang PublikDigital — marketplace produk digital premium untuk kreator Indonesia.')

@section('content')
<section class="section" style="padding-top:120px;">
    <div class="container">
        <div style="max-width:720px; margin:0 auto; text-align:center;">
            <span class="hero-badge">Tentang Kami</span>
            <h1 class="display-lg hero-title">PublikDigital</h1>
            <p class="hero-subtitle" style="margin:0 auto var(--space-4);">
                Marketplace produk digital premium yang memberdayakan kreator, developer, dan desainer Indonesia untuk berkarya dan berkembang.
            </p>
        </div>
    </div>
</section>

<section class="section" style="background:var(--color-surface-container-low);">
    <div class="container">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:var(--space-6); align-items:start;">
            <div>
                <h2 class="headline-sm" style="margin-bottom:var(--space-3);">Visi</h2>
                <p class="body-md" style="color:var(--color-on-surface-variant); line-height:1.8;">
                    Menjadi ekosistem digital terdepan di Indonesia yang menghubungkan kreator dengan pengguna produk digital berkualitas tinggi.
                </p>
            </div>
            <div>
                <h2 class="headline-sm" style="margin-bottom:var(--space-3);">Misi</h2>
                <ul style="color:var(--color-on-surface-variant); line-height:2; list-style:none; padding:0;">
                    <li style="padding:4px 0;">&check; Menyediakan platform yang aman dan terpercaya</li>
                    <li style="padding:4px 0;">&check; Mendukung kreator lokal dengan distribusi digital</li>
                    <li style="padding:4px 0;">&check; Memberikan pengalaman belanja yang mulus dan modern</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2 class="headline-sm" style="text-align:center; margin-bottom:var(--space-6);">Mengapa PublikDigital?</h2>
        <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:var(--space-4);">
            @foreach([
                ['Premium Quality', 'Produk digital terkurasi dengan standar kualitas tertinggi.'],
                ['Instant Delivery', 'Akses langsung setelah pembayaran dikonfirmasi.'],
                ['Support Cepat', 'Tim support siap membantu 24/7 melalui chat dan email.'],
            ] as [$title, $desc])
                <div style="background:var(--color-surface-container); border:1px solid var(--color-outline-variant); border-radius:var(--radius-lg); padding:var(--space-4);">
                    <h3 class="headline-sm" style="font-size:1.25rem; margin-bottom:var(--space-2);">{{ $title }}</h3>
                    <p style="color:var(--color-on-surface-variant);">{{ $desc }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
