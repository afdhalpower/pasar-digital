@extends('layouts.marketplace')

@section('title', 'Kontak')
@section('meta_description', 'Hubungi tim PublikDigital untuk pertanyaan, saran, atau kerja sama.')

@section('content')
<section class="section" style="padding-top:120px;">
    <div class="container" style="max-width:720px;">
        <div style="text-align:center; margin-bottom:var(--space-6);">
            <span class="hero-badge">Kontak</span>
            <h1 class="headline-sm" style="margin-top:var(--space-2);">Hubungi Kami</h1>
            <p class="hero-subtitle" style="margin:var(--space-2) auto 0;">Punya pertanyaan atau ingin kerja sama? Jangan ragu untuk menghubungi kami.</p>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:var(--space-6);">
            <div style="display:flex; flex-direction:column; gap:var(--space-4);">
                <div style="background:var(--color-surface-container); border:1px solid var(--color-outline-variant); border-radius:var(--radius-lg); padding:var(--space-3);">
                    <h3 style="font-weight:600; margin-bottom:var(--space-1);">Email</h3>
                    <p style="color:var(--color-on-surface-variant); font-size:0.875rem;">hello@publikdigital.id</p>
                </div>
                <div style="background:var(--color-surface-container); border:1px solid var(--color-outline-variant); border-radius:var(--radius-lg); padding:var(--space-3);">
                    <h3 style="font-weight:600; margin-bottom:var(--space-1);">Jam Operasional</h3>
                    <p style="color:var(--color-on-surface-variant); font-size:0.875rem;">Senin — Jumat, 09:00 — 17:00 WIB</p>
                </div>
                <div style="background:var(--color-surface-container); border:1px solid var(--color-outline-variant); border-radius:var(--radius-lg); padding:var(--space-3);">
                    <h3 style="font-weight:600; margin-bottom:var(--space-1);">Chat</h3>
                    <p style="color:var(--color-on-surface-variant); font-size:0.875rem;">Gunakan fitur Percakapan setelah login untuk respon lebih cepat.</p>
                </div>
            </div>
            <div style="background:var(--color-surface-container); border:1px solid var(--color-outline-variant); border-radius:var(--radius-lg); padding:var(--space-4);">
                <h3 style="font-weight:600; margin-bottom:var(--space-3);">Kirim Pesan</h3>
                <form>
                    @csrf
                    <div style="display:flex; flex-direction:column; gap:var(--space-2);">
                        <input type="text" placeholder="Nama" class="input-field" disabled>
                        <input type="email" placeholder="Email" class="input-field" disabled>
                        <textarea rows="4" placeholder="Pesan" class="input-field" disabled></textarea>
                        <button type="button" class="btn btn-primary btn-pill" disabled>Kirim</button>
                    </div>
                </form>
                <p style="font-size:0.75rem; color:var(--color-outline); margin-top:var(--space-2);">Fitur ini masih dalam pengembangan. Hubungi via email untuk saat ini.</p>
            </div>
        </div>
    </div>
</section>
@endsection
