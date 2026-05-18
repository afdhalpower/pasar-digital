@extends('layouts.marketplace')

@section('title', 'Beranda')

@section('content')
{{-- Hero Section --}}
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <span class="hero-badge animate-in">✨ Marketplace Digital #1 Indonesia</span>
            <h1 class="display-lg hero-title animate-in animate-delay-1">
                Produk Digital<br>
                <span style="color: var(--color-primary)">Berkualitas Premium</span>
            </h1>
            <p class="hero-subtitle animate-in animate-delay-2">
                Temukan template, software, dan aset digital terbaik dari kreator Indonesia. Bangun proyek impianmu dengan produk yang sudah teruji.
            </p>
            <div class="hero-actions animate-in animate-delay-3">
                <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-lg btn-pill">
                    Jelajahi Katalog
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="#featured" class="btn btn-secondary btn-lg btn-pill">Produk Unggulan</a>
            </div>

            <div class="stats-bar animate-in animate-delay-3">
                <div class="stat-item">
                    <div class="stat-value">500+</div>
                    <div class="stat-label">Produk Digital</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">2.5K+</div>
                    <div class="stat-label">Kreator Aktif</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">10K+</div>
                    <div class="stat-label">Download</div>
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
                <h2 class="headline-md">Kategori Populer</h2>
                <p class="subtitle body-md">Temukan produk sesuai kebutuhanmu</p>
            </div>
        </div>
        <div style="display:flex; flex-wrap:wrap; gap:12px;">
            @forelse($categories as $cat)
                <a href="{{ route('catalog.index', ['category' => $cat->slug]) }}" class="chip chip-primary">
                    {{ $cat->name }}
                    <span style="margin-left:6px; opacity:0.7;">({{ $cat->active_products_count }})</span>
                </a>
            @empty
                <p style="color: var(--color-on-surface-variant);">Belum ada kategori. Tambahkan melalui <a href="/admin" style="color:var(--color-primary);">Admin Panel</a>.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- Featured Products --}}
<section class="section" id="featured">
    <div class="container">
        <div class="section-header">
            <div>
                <h2 class="headline-md">Produk Unggulan</h2>
                <p class="subtitle body-md">Pilihan terbaik dari kurator kami</p>
            </div>
            <a href="{{ route('catalog.index') }}" class="btn btn-secondary btn-pill">Lihat Semua</a>
        </div>
        <div class="grid-products">
            @forelse($featuredProducts as $product)
                @include('components.product-card', ['product' => $product])
            @empty
                <p style="color: var(--color-on-surface-variant); grid-column: 1/-1; text-align:center; padding: 60px 0;">
                    Belum ada produk unggulan. Tambahkan produk melalui <a href="/admin" style="color:var(--color-primary);">Admin Panel</a>.
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
                <h2 class="headline-md">Terbaru</h2>
                <p class="subtitle body-md">Produk digital yang baru saja ditambahkan</p>
            </div>
            <a href="{{ route('catalog.index', ['sort' => 'latest']) }}" class="btn btn-secondary btn-pill">Lihat Semua</a>
        </div>
        <div class="grid-products">
            @forelse($latestProducts as $product)
                @include('components.product-card', ['product' => $product])
            @empty
                <p style="color: var(--color-on-surface-variant); grid-column: 1/-1; text-align:center; padding: 60px 0;">
                    Belum ada produk. Mulai tambahkan melalui <a href="/admin" style="color:var(--color-primary);">Admin Panel</a>.
                </p>
            @endforelse
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="section-lg" style="text-align:center;">
    <div class="container">
        <h2 class="headline-md" style="margin-bottom: var(--space-2);">Siap Memulai?</h2>
        <p class="body-lg" style="color: var(--color-on-surface-variant); max-width: 500px; margin: 0 auto var(--space-4);">
            Bergabung dengan ribuan kreator dan pembeli di marketplace digital terdepan Indonesia.
        </p>
        <a href="{{ url('/admin/register') }}" class="btn btn-primary btn-lg btn-pill">Daftar Sekarang — Gratis</a>
    </div>
</section>
@endsection
