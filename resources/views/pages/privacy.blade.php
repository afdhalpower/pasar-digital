@extends('layouts.marketplace')

@section('title', __('marketplace.privacy_title'))
@section('meta_description', 'Kebijakan privasi PublikDigital — bagaimana kami mengelola dan melindungi data Anda.')

@section('content')
<section class="section" style="padding-top:120px;">
    <div class="container" style="max-width:720px;">
        <div style="text-align:center; margin-bottom:var(--space-6);">
            <span class="hero-badge">{{ __('marketplace.privacy_badge') }}</span>
            <h1 class="headline-sm" style="margin-top:var(--space-2);">{{ __('marketplace.privacy_heading') }}</h1>
            <p class="hero-subtitle" style="margin:var(--space-2) auto 0;">{{ __('marketplace.privacy_updated') }}</p>
        </div>

        <div style="display:flex; flex-direction:column; gap:var(--space-4); color:var(--color-on-surface-variant); line-height:1.8; font-size:0.95rem;">
            <section>
                <h2 style="color:var(--color-on-surface); font-size:1.25rem; font-weight:600; margin-bottom:var(--space-2);">1. Informasi yang Kami Kumpulkan</h2>
                <p>Kami mengumpulkan informasi yang Anda berikan saat mendaftar, termasuk nama, alamat email, dan data profil lainnya. Kami juga mencatat data transaksi dan interaksi Anda dengan platform.</p>
            </section>
            <section>
                <h2 style="color:var(--color-on-surface); font-size:1.25rem; font-weight:600; margin-bottom:var(--space-2);">2. Penggunaan Informasi</h2>
                <p>Informasi Anda digunakan untuk memproses pesanan, memberikan dukungan pelanggan, mengirim notifikasi terkait transaksi, serta meningkatkan kualitas layanan kami.</p>
            </section>
            <section>
                <h2 style="color:var(--color-on-surface); font-size:1.25rem; font-weight:600; margin-bottom:var(--space-2);">3. Keamanan Data</h2>
                <p>Kami menerapkan langkah-langkah keamanan teknis dan organisasi yang sesuai untuk melindungi data pribadi Anda dari akses tidak sah, perubahan, pengungkapan, atau penghancuran.</p>
            </section>
            <section>
                <h2 style="color:var(--color-on-surface); font-size:1.25rem; font-weight:600; margin-bottom:var(--space-2);">4. Pembagian Data</h2>
                <p>Kami tidak menjual atau menyewakan data pribadi Anda kepada pihak ketiga. Data hanya dibagikan dengan penyedia layanan yang mendukung operasional platform kami (seperti payment gateway) dan terikat perjanjian kerahasiaan.</p>
            </section>
            <section>
                <h2 style="color:var(--color-on-surface); font-size:1.25rem; font-weight:600; margin-bottom:var(--space-2);">5. Hak Anda</h2>
                <p>Anda berhak mengakses, memperbarui, atau menghapus data pribadi Anda kapan saja melalui pengaturan profil atau dengan menghubungi tim dukungan kami.</p>
            </section>
            <section>
                <h2 style="color:var(--color-on-surface); font-size:1.25rem; font-weight:600; margin-bottom:var(--space-2);">6. Kontak</h2>
                <p>Jika ada pertanyaan mengenai kebijakan privasi ini, silakan hubungi kami di <strong>hello@publikdigital.id</strong>.</p>
            </section>
        </div>
    </div>
</section>
@endsection
