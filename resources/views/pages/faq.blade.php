@extends('layouts.marketplace')

@section('title', __('marketplace.faq_title'))
@section('meta_description', 'Pertanyaan yang sering diajukan seputar PublikDigital.')

@section('content')
<section class="section" style="padding-top:120px;">
    <div class="container" style="max-width:720px;">
        <div style="text-align:center; margin-bottom:var(--space-6);">
            <span class="hero-badge">{{ __('marketplace.faq_badge') }}</span>
            <h1 class="headline-sm" style="margin-top:var(--space-2);">{{ __('marketplace.faq_heading') }}</h1>
            <p class="hero-subtitle" style="margin:var(--space-2) auto 0;">{{ __('marketplace.faq_subtitle') }}</p>
        </div>

        @php
            $faqs = [
                ['q' => 'Bagaimana cara membeli produk?', 'a' => 'Tambah produk ke keranjang, lakukan checkout, lalu transfer pembayaran sesuai instruksi. Admin akan memverifikasi dan pesanan selesai dalam 1x24 jam.'],
                ['q' => 'Pembayaran apa yang didukung?', 'a' => 'Saat ini kami mendukung pembayaran melalui transfer bank manual (BCA, Mandiri, BRI). Setiap pesanan dilengkapi kode unik untuk memudahkan verifikasi.'],
                ['q' => 'Bagaimana cara download setelah membeli?', 'a' => 'Setelah pembayaran dikonfirmasi oleh admin, file produk akan tersedia di halaman Pesanan Saya > Download.'],
                ['q' => 'Apakah produk bisa diretur?', 'a' => 'Karena bersifat digital, produk tidak dapat diretur setelah di-download. Jika ada masalah teknis, silakan hubungi kami melalui chat atau email.'],
                ['q' => 'Bagaimana cara menghubungi penjual?', 'a' => 'Anda bisa mengirim pesan melalui fitur Tanya di halaman produk atau melalui menu Percakapan setelah login.'],
                ['q' => 'Apakah saya perlu akun untuk membeli?', 'a' => 'Ya, Anda perlu mendaftar akun untuk dapat melakukan pembelian dan mengakses produk yang sudah dibeli.'],
            ];
        @endphp

        <div style="display:flex; flex-direction:column; gap:var(--space-2);">
            @foreach($faqs as $i => $faq)
                <details style="background:var(--color-surface-container); border:1px solid var(--color-outline-variant); border-radius:var(--radius-md); overflow:hidden;">
                    <summary style="padding:var(--space-2) var(--space-3); cursor:pointer; font-weight:600; font-size:0.95rem; list-style:none; display:flex; align-items:center; justify-content:space-between;">
                        <span>{{ $faq['q'] }}</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="transition:transform 0.2s;">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </summary>
                    <div style="padding:0 var(--space-3) var(--space-2); color:var(--color-on-surface-variant); font-size:0.9rem; line-height:1.7;">
                        {{ $faq['a'] }}
                    </div>
                </details>
            @endforeach
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('details').forEach(d => {
        d.querySelector('summary')?.addEventListener('click', e => {
            const svg = d.querySelector('summary svg');
            if (d.open) {
                svg.style.transform = 'rotate(0deg)';
            } else {
                svg.style.transform = 'rotate(180deg)';
            }
        });
    });
</script>
@endpush
