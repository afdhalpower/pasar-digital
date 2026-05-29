@extends('layouts.marketplace')

@section('title', __('auth.reset_title'))

@section('content')
<div class="container" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding-top: 72px;">
    <div style="width: 100%; max-width: 420px;">
        <div style="text-align: center; margin-bottom: var(--space-6);">
            <h1 class="headline-md" style="margin-bottom: 8px;">{{ __('auth.reset_heading') }}</h1>
            <p style="color: var(--color-on-surface-variant); font-size: 0.875rem;">
                {{ __('auth.reset_instruction') }}
            </p>
        </div>

        <form method="POST" action="{{ route('password.update') }}" style="display: flex; flex-direction: column; gap: var(--space-3);">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="email" class="form-label">{{ __('auth.email_label') }}</label>
                <input id="email" type="email" name="email" class="input-field @error('email') is-invalid @enderror" value="{{ old('email', $email) }}" required readonly style="opacity: 0.7;">
                @error('email')
                    <p class="input-hint" style="color: var(--color-error); margin-top: 4px;">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">{{ __('auth.reset_password_label') }}</label>
                <input id="password" type="password" name="password" class="input-field @error('password') is-invalid @enderror" required minlength="8" placeholder="{{ __('auth.password_placeholder') }}">
                @error('password')
                    <p class="input-hint" style="color: var(--color-error); margin-top: 4px;">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">{{ __('auth.password_confirm_label') }}</label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="input-field" required placeholder="{{ __('auth.password_confirm_placeholder') }}">
            </div>

            <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; justify-content: center;">
                {{ __('auth.reset_button') }}
            </button>
        </form>
    </div>
</div>
@endsection
