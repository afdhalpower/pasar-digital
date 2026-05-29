@extends('layouts.marketplace')

@section('title', __('marketplace.terms_title'))

@section('meta_description', 'Syarat dan ketentuan penggunaan platform PublikDigital - Marketplace produk digital premium untuk kreator Indonesia.')

@section('content')
<section class="section-lg" style="padding-top: 120px;">
    <div class="container" style="max-width: 800px;">
        <div class="animate-in">
            <span class="label-sm" style="color: var(--color-primary);">{{ __('marketplace.terms_badge') }}</span>
            <h1 class="headline-md" style="margin-top: 8px; margin-bottom: var(--space-2);">{{ __('marketplace.terms_heading') }}</h1>
            <p style="color: var(--color-on-surface-variant); font-size: 0.875rem; margin-bottom: var(--space-5);">{{ __('marketplace.terms_updated', ['date' => date('d F Y')]) }}</p>
        </div>

        <div style="display: flex; flex-direction: column; gap: var(--space-4);">
            <div class="animate-in animate-delay-1">
                <h2 class="headline-sm" style="font-size: 1.25rem; margin-bottom: var(--space-2);">1. Penerimaan Ketentuan</h2>
                <p style="color: var(--color-on-surface-variant); line-height: 1.8;">Dengan mengakses dan menggunakan platform PublikDigital, Anda menyatakan telah membaca, memahami, dan menyetujui untuk terikat oleh seluruh syarat dan ketentuan ini. Jika Anda tidak menyetujui salah satu bagian dari ketentuan ini, Anda tidak diperkenankan menggunakan layanan kami.</p>
            </div>

            <div class="animate-in animate-delay-1">
                <h2 class="headline-sm" style="font-size: 1.25rem; margin-bottom: var(--space-2);">2. Definisi</h2>
                <ul style="color: var(--color-on-surface-variant); line-height: 1.8; padding-left: 20px;">
                    <li><strong>Platform</strong> — PublikDigital, marketplace produk digital.</li>
                    <li><strong>Penjual/Kreator</strong> — Pihak yang mengunggah dan menjual produk digital melalui platform.</li>
                    <li><strong>Pembeli</strong> — Pihak yang membeli dan mengunduh produk digital dari platform.</li>
                    <li><strong>Produk Digital</strong> — Aset digital seperti template, software, UI kit, grafik, e-book, dan lain-lain.</li>
                </ul>
            </div>

            <div class="animate-in animate-delay-2">
                <h2 class="headline-sm" style="font-size: 1.25rem; margin-bottom: var(--space-2);">3. Akun Pengguna</h2>
                <p style="color: var(--color-on-surface-variant); line-height: 1.8;">Anda bertanggung jawab penuh atas kerahasiaan kredensial akun Anda. Setiap aktivitas yang terjadi dalam akun Anda adalah tanggung jawab Anda. Anda wajib memberi tahu kami segera jika mengetahui adanya akses tidak sah ke akun Anda.</p>
            </div>

            <div class="animate-in animate-delay-2">
                <h2 class="headline-sm" style="font-size: 1.25rem; margin-bottom: var(--space-2);">4. Transaksi & Pembayaran</h2>
                <p style="color: var(--color-on-surface-variant); line-height: 1.8;">Seluruh transaksi dilakukan dalam Rupiah (IDR). Pembayaran dilakukan melalui metode transfer bank yang tersedia. Produk digital akan tersedia untuk diunduh setelah pembayaran diverifikasi oleh tim kami.</p>
            </div>

            <div class="animate-in animate-delay-2">
                <h2 class="headline-sm" style="font-size: 1.25rem; margin-bottom: var(--space-2);">5. Kebijakan Refund</h2>
                <p style="color: var(--color-on-surface-variant); line-height: 1.8;">Mengingat sifat produk digital yang tidak dapat dikembalikan secara fisik, refund hanya diberikan dalam kondisi tertentu seperti: produk rusak/tidak berfungsi sesuai deskripsi, atau produk tidak sesuai dengan yang dipesan. Klaim refund harus diajukan maksimal 7 hari setelah pembelian.</p>
            </div>

            <div class="animate-in animate-delay-3">
                <h2 class="headline-sm" style="font-size: 1.25rem; margin-bottom: var(--space-2);">6. Hak Kekayaan Intelektual</h2>
                <p style="color: var(--color-on-surface-variant); line-height: 1.8;">Seluruh produk digital yang dijual di platform ini dilindungi oleh hak cipta dan hak kekayaan intelektual yang berlaku. Pembeli dilarang menggandakan, mendistribusikan ulang, atau menjual kembali produk yang dibeli tanpa izin tertulis dari pencipta.</p>
            </div>

            <div class="animate-in animate-delay-3">
                <h2 class="headline-sm" style="font-size: 1.25rem; margin-bottom: var(--space-2);">7. Batasan Tanggung Jawab</h2>
                <p style="color: var(--color-on-surface-variant); line-height: 1.8;">PublikDigital tidak bertanggung jawab atas kerugian langsung atau tidak langsung yang timbul dari penggunaan platform ini. Platform disediakan "sebagaimana adanya" tanpa jaminan apapun.</p>
            </div>

            <div class="animate-in animate-delay-3">
                <h2 class="headline-sm" style="font-size: 1.25rem; margin-bottom: var(--space-2);">8. Perubahan Ketentuan</h2>
                <p style="color: var(--color-on-surface-variant); line-height: 1.8;">Kami berhak mengubah syarat dan ketentuan ini sewaktu-waktu. Perubahan akan diumumkan melalui platform dan berlaku efektif setelah pengumuman tersebut.</p>
            </div>

            <div class="animate-in animate-delay-3">
                <h2 class="headline-sm" style="font-size: 1.25rem; margin-bottom: var(--space-2);">9. Kontak</h2>
                <p style="color: var(--color-on-surface-variant); line-height: 1.8;">Jika Anda memiliki pertanyaan mengenai syarat dan ketentuan ini, silakan hubungi kami melalui halaman <a href="{{ route('contact') }}" style="color: var(--color-primary);">{{ __('marketplace.contact_title') }}</a>.</p>
            </div>
        </div>
    </div>
</section>
@endsection
