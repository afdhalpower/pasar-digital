@extends('layouts.marketplace')

@section('title', 'Lupa Password')

@section('content')
<div class="container" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding-top: 72px;">
    <div style="width: 100%; max-width: 420px;">
        <div style="text-align: center; margin-bottom: var(--space-6);">
            <h1 class="headline-md" style="margin-bottom: 8px;">Lupa Password</h1>
            <p style="color: var(--color-on-surface-variant); font-size: 0.875rem;">
                Masukkan email Anda dan kami akan kirim link reset password.
            </p>
        </div>

        <form method="POST" action="{{ route('password.email') }}" style="display: flex; flex-direction: column; gap: var(--space-3);">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" class="input-field @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                @error('email')
                    <p class="input-hint" style="color: var(--color-error); margin-top: 4px;">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; justify-content: center;">
                Kirim Link Reset
            </button>

            <p style="text-align: center; font-size: 0.875rem; color: var(--color-on-surface-variant);">
                Ingat password Anda?
                <a href="{{ route('login') }}" style="color: var(--color-primary);">Masuk</a>
            </p>
        </form>
    </div>
</div>
@endsection
