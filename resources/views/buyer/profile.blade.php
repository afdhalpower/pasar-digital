@extends('layouts.marketplace')

@section('title', 'Pengaturan Profil')



@section('content')
<div class="container" style="padding-top: 120px; padding-bottom: var(--space-8); min-height: 85vh;">
    <div style="display: grid; grid-template-columns: 280px 1fr; gap: var(--space-5);" class="dashboard-grid">
        
        {{-- Sidebar --}}
        @include('buyer.sidebar')

        {{-- Main Content --}}
        <main class="dashboard-content-area animate-in">
            <div style="margin-bottom: var(--space-4);">
                <span class="label-sm" style="color: var(--color-primary);">Akun Anda</span>
                <h1 class="headline-md" style="margin-top: 4px;">Pengaturan Profil</h1>
                <p style="color: var(--color-on-surface-variant); font-size: 0.875rem;">Perbarui informasi pribadi dan amankan akun Anda di sini.</p>
            </div>

            <div style="background: var(--color-surface-container); border: 1px solid var(--color-outline-variant); border-radius: var(--radius-lg); padding: var(--space-4) var(--space-5);">
                
                {{-- Flash Notifications --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <div style="display: flex; flex-direction: column;">
                            <span style="font-weight: 600;">Terjadi beberapa kesalahan:</span>
                            <ul style="margin-left: 16px; margin-top: 4px; padding-left: 0;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('buyer.profile.update') }}" method="POST" autocomplete="off">
                    @csrf

                    {{-- Section: Personal Info --}}
                    <div style="margin-bottom: var(--space-4);">
                        <h2 class="form-section-title">Informasi Pribadi</h2>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-3);" class="dashboard-grid">
                            <div class="form-group">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" id="name" class="input-field" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <span style="color: var(--color-error); font-size: 0.75rem; display: block; margin-top: 4px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">Alamat Email</label>
                                <input type="email" name="email" id="email" class="input-field" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <span style="color: var(--color-error); font-size: 0.75rem; display: block; margin-top: 4px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Section: Security/Password --}}
                    <div style="margin-bottom: var(--space-4);">
                        <h2 class="form-section-title">Ubah Password</h2>
                        <p style="color: var(--color-on-surface-variant); font-size: 0.8rem; margin-top: -8px; margin-bottom: 16px;">
                            Biarkan kosong jika Anda tidak ingin mengubah password saat ini.
                        </p>

                        <div class="form-group">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <input type="password" name="current_password" id="current_password" class="input-field" placeholder="••••••••" autocomplete="new-password">
                            <span class="input-hint">Wajib diisi jika Anda ingin mengganti password baru.</span>
                            @error('current_password')
                                <span style="color: var(--color-error); font-size: 0.75rem; display: block; margin-top: 4px;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-3);" class="dashboard-grid">
                            <div class="form-group">
                                <label for="new_password" class="form-label">Password Baru</label>
                                <input type="password" name="new_password" id="new_password" class="input-field" placeholder="Minimal 8 karakter">
                                @error('new_password')
                                    <span style="color: var(--color-error); font-size: 0.75rem; display: block; margin-top: 4px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="input-field" placeholder="Ulangi password baru">
                            </div>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div style="display: flex; justify-content: flex-end; margin-top: var(--space-2); padding-top: var(--space-3); border-top: 1px solid var(--color-outline-variant);">
                        <button type="submit" class="btn btn-primary" style="padding: 12px 32px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 4px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection
