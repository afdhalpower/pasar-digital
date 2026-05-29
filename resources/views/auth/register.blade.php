@extends('layouts.marketplace')

@section('title', __('auth.register_title'))

@section('content')
<section class="section" style="min-height: 85vh; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; padding-top: 100px;">
    {{-- Decorative Background Orbs --}}
    <div style="position: absolute; top: 10%; right: 15%; width: 300px; height: 300px; background: radial-gradient(circle, rgba(13, 148, 136, 0.12) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>
    <div style="position: absolute; bottom: 10%; left: 15%; width: 250px; height: 250px; background: radial-gradient(circle, rgba(210, 121, 86, 0.08) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>

    <div class="container" style="max-width: 480px; position: relative; z-index: 2;">
        <div style="background: var(--glass-bg); backdrop-filter: blur(var(--glass-blur)); -webkit-backdrop-filter: blur(var(--glass-blur)); border: 1px solid var(--glass-border); padding: var(--space-5); border-radius: var(--radius-xl); box-shadow: var(--shadow-lg);" class="animate-in">
            
            <div style="text-align: center; margin-bottom: var(--space-4);">
                <span class="label-sm" style="color: var(--color-primary); letter-spacing: 0.1em;">{{ __('auth.register_badge') }}</span>
                <h2 class="headline-sm" style="margin-top: 8px; font-size: 1.75rem;">{{ __('auth.register_heading') }}</h2>
                <p style="color: var(--color-on-surface-variant); font-size: 0.875rem; margin-top: 4px;">{{ __('auth.register_subtitle') }}</p>
            </div>

            @if ($errors->any())
                <div style="background: rgba(255, 180, 171, 0.1); border: 1px solid var(--color-error); color: var(--color-error); padding: 12px 16px; border-radius: var(--radius-md); font-size: 0.875rem; margin-bottom: var(--space-3);">
                    <ul style="list-style: none; margin: 0; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" style="display: flex; flex-direction: column; gap: var(--space-3);">
                @csrf
                <div>
                    <label for="name" style="display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 6px; color: var(--color-on-surface);">{{ __('auth.name_label') }}</label>
                    <input type="text" name="name" id="name" class="input-field" placeholder="{{ __('auth.name_placeholder') }}" value="{{ old('name') }}" required autofocus autocomplete="name">
                </div>

                <div>
                    <label for="email" style="display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 6px; color: var(--color-on-surface);">{{ __('auth.email_label') }}</label>
                    <input type="email" name="email" id="email" class="input-field" placeholder="{{ __('auth.email_placeholder') }}" value="{{ old('email') }}" required autocomplete="email">
                </div>

                <div>
                    <label for="password" style="display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 6px; color: var(--color-on-surface);">{{ __('auth.password_label') }}</label>
                    <input type="password" name="password" id="password" class="input-field" placeholder="{{ __('auth.password_placeholder') }}" required autocomplete="new-password">
                </div>

                <div>
                    <label for="password_confirmation" style="display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 6px; color: var(--color-on-surface);">{{ __('auth.password_confirm_label') }}</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="input-field" placeholder="{{ __('auth.password_confirm_placeholder') }}" required autocomplete="new-password">
                </div>

                <button type="submit" class="btn btn-primary" style="margin-top: var(--space-2); width: 100%; padding: 14px;">
                    {{ __('auth.register_button') }}
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-left: 4px;"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </button>
            </form>

            <div style="text-align: center; margin-top: var(--space-4); border-top: 1px solid var(--color-outline-variant); padding-top: var(--space-3);">
                <p style="color: var(--color-on-surface-variant); font-size: 0.875rem;">
                    {{ __('auth.has_account') }} 
                    <a href="{{ route('login') }}" style="color: var(--color-primary); font-weight: 600; text-decoration: none;">{{ __('auth.login_here') }}</a>
                </p>
            </div>

        </div>
    </div>
</section>
@endsection
