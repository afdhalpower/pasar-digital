@extends('layouts.marketplace')

@section('title', 'Produk Saya')

@section('content')
<div class="container" style="padding-top: 120px; padding-bottom: var(--space-8); min-height: 85vh;">
    <div style="display: grid; grid-template-columns: 280px 1fr; gap: var(--space-5);" class="dashboard-grid">
        @include('buyer.sidebar')

        <main class="dashboard-content-area animate-in">
            <div style="margin-bottom: var(--space-4);">
                <span class="label-sm" style="color: var(--color-primary);">Produk Digital Anda</span>
                <h1 class="headline-md" style="margin-top: 4px;">Produk Saya</h1>
                <p style="color: var(--color-on-surface-variant); font-size: 0.875rem;">Akses dan unduh seluruh berkas produk digital yang telah sukses Anda beli.</p>
            </div>

            {{-- Search --}}
            <form method="GET" action="{{ route('buyer.downloads') }}" style="display: flex; gap: 12px; margin-bottom: var(--space-4);">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..." class="input-field" style="max-width: 300px;">
                <button type="submit" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.8rem;">Cari</button>
                @if(request()->filled('search'))
                    <a href="{{ route('buyer.downloads') }}" class="btn btn-secondary" style="padding: 8px 16px; font-size: 0.8rem;">Reset</a>
                @endif
            </form>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: var(--gutter);">
                @forelse ($downloads as $item)
                    @if ($item->product)
                        <div class="download-card">
                            @if ($item->product->getThumbnailUrl())
                                <img src="{{ $item->product->getThumbnailUrl() }}" alt="{{ $item->product->name }}">
                            @else
                                <div style="width: 100%; aspect-ratio: 16/9; background: linear-gradient(135deg, var(--color-surface-container-high) 0%, var(--color-surface-container-highest) 100%); display: flex; align-items: center; justify-content: center; color: var(--color-outline);">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                                </div>
                            @endif
                            <div class="download-card-body">
                                <div>
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                                        <span class="label-sm" style="color: var(--color-primary);">{{ $item->product->category->name ?? 'Kategori' }}</span>
                                        <span class="label-sm" style="color: var(--color-on-surface-variant); background: rgba(255,255,255,0.05); padding: 2px 6px; border-radius: var(--radius-sm); font-size: 0.65rem;">{{ strtoupper($item->product->type) }}</span>
                                    </div>
                                    <h3 class="download-card-title">
                                        <a href="{{ route('catalog.show', $item->product->slug) }}">{{ $item->product->name }}</a>
                                    </h3>
                                    
                                    <div class="download-card-meta">
                                        <span>Dipesan pada: {{ $item->created_at->format('d M Y') }}</span>
                                        <span>No. Pesanan: <strong style="color: var(--color-on-surface);">{{ $item->order->order_number }}</strong></span>
                                    </div>
                                </div>
                                
                                <div style="display: flex; gap: 8px; margin-top: var(--space-2);">
                                    @if ($item->product->demo_url)
                                        <a href="{{ $item->product->demo_url }}" target="_blank" class="btn btn-secondary" style="flex: 1; padding: 10px; font-size: 0.8rem; border-radius: var(--radius-md);">
                                            Demo
                                        </a>
                                    @endif
                                    <a href="{{ route('buyer.download-file', $item->product) }}" class="btn btn-primary" style="flex: 2; padding: 10px; font-size: 0.8rem; border-radius: var(--radius-md);">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 4px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                                        Unduh
                                    </a>
                                </div>

                                {{-- Review button for paid items --}}
                                @php
                                    $existingReview = $item->product->reviews()->where('user_id', auth()->id())->first();
                                @endphp
                                @if($existingReview)
                                    <div style="margin-top: 8px; padding-top: 8px; border-top: 1px solid var(--color-outline-variant);">
                                        <span style="font-size: 0.75rem; color: var(--color-on-surface-variant);">
                                            Ulasan Anda: 
                                            @for($i = 1; $i <= 5; $i++)
                                                <span style="color: {{ $i <= $existingReview->rating ? 'var(--color-warning)' : 'var(--color-outline-variant)' }};">&#9733;</span>
                                            @endfor
                                        </span>
                                    </div>
                                @else
                                    <div style="margin-top: 8px; padding-top: 8px; border-top: 1px solid var(--color-outline-variant);">
                                        <a href="{{ route('catalog.show', $item->product->slug) }}#review-form" style="font-size: 0.75rem; color: var(--color-primary); text-decoration: none; font-weight: 500;">
                                            + Beri Ulasan
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                @empty
                    <div style="grid-column: 1/-1; text-align: center; padding: 80px 0; background: var(--color-surface-container); border: 1px solid var(--color-outline-variant); border-radius: var(--radius-lg);">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--color-outline)" stroke-width="1.5" style="margin-bottom:16px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                        <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--color-on-surface); margin-bottom: 8px;">
                            @if(request()->filled('search'))
                                Produk tidak ditemukan
                            @else
                                Belum ada produk yang dibeli
                            @endif
                        </h3>
                        <p style="color: var(--color-on-surface-variant); font-size: 0.875rem; margin-bottom: 20px;">
                            @if(request()->filled('search'))
                                Coba ubah kata kunci pencarian.
                            @else
                                Silakan beli produk digital di katalog kami terlebih dahulu untuk melihat unduhan Anda di sini.
                            @endif
                        </p>
                        @unless(request()->filled('search'))
                            <a href="{{ route('catalog.index') }}" class="btn btn-primary" style="padding: 8px 20px; font-size: 0.875rem;">Telusuri Katalog</a>
                        @endunless
                    </div>
                @endforelse
            </div>

            @if($downloads->hasPages())
                <div style="display:flex; justify-content:center; margin-top:var(--space-6);">
                    {{ $downloads->withQueryString()->links() }}
                </div>
            @endif
        </main>
    </div>
</div>
@endsection
