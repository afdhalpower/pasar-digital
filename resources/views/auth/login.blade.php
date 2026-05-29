@extends('layouts.marketplace')

@section('title', __('auth.login_title'))

@section('content')
<section class="section" style="min-height: 85vh; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; padding-top: 100px;">
    {{-- Decorative Background Orbs --}}
    <div style="position: absolute; top: 10%; left: 15%; width: 300px; height: 300px; background: radial-gradient(circle, rgba(13, 148, 136, 0.12) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>
    <div style="position: absolute; bottom: 10%; right: 15%; width: 250px; height: 250px; background: radial-gradient(circle, rgba(210, 121, 86, 0.08) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>

    <div class="container" style="max-width: 480px; position: relative; z-index: 2;">
        <div style="background: var(--glass-bg); backdrop-filter: blur(var(--glass-blur)); -webkit-backdrop-filter: blur(var(--glass-blur)); border: 1px solid var(--glass-border); padding: var(--space-5); border-radius: var(--radius-xl); box-shadow: var(--shadow-lg);" class="animate-in">
            
            <div style="text-align: center; margin-bottom: var(--space-4);">
                <span class="label-sm" style="color: var(--color-primary); letter-spacing: 0.1em;">{{ __('auth.login_badge') }}</span>
                <h2 class="headline-sm" style="margin-top: 8px; font-size: 1.75rem;">{{ __('auth.login_heading') }}</h2>
                <p style="color: var(--color-on-surface-variant); font-size: 0.875rem; margin-top: 4px;">{{ __('auth.login_subtitle') }}</p>
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

            <form action="{{ route('login') }}" method="POST" style="display: flex; flex-direction: column; gap: var(--space-3);">
                @csrf
                <div>
                    <label for="email" style="display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 6px; color: var(--color-on-surface);">{{ __('auth.email_label') }}</label>
                    <input type="email" name="email" id="email" class="input-field" placeholder="{{ __('auth.email_placeholder') }}" value="{{ old('email') }}" required autofocus autocomplete="email">
                </div>

                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label for="password" style="font-size: 0.875rem; font-weight: 500; color: var(--color-on-surface);">{{ __('auth.password_label') }}</label>
                        <a href="{{ route('password.request') }}" style="font-size: 0.75rem; color: var(--color-primary); text-decoration: none;">{{ __('auth.forgot_password') }}</a>
                    </div>
                    <input type="password" name="password" id="password" class="input-field" placeholder="{{ __('auth.password_placeholder') }}" required autocomplete="current-password">
                </div>

                <div style="display: flex; align-items: center; gap: 8px; margin-top: 4px;">
                    <input type="checkbox" name="remember" id="remember" style="accent-color: var(--color-primary); width: 16px; height: 16px; cursor: pointer;">
                    <label for="remember" style="font-size: 0.875rem; color: var(--color-on-surface-variant); cursor: pointer; user-select: none;">{{ __('auth.remember_me') }}</label>
                </div>

                <button type="submit" class="btn btn-primary" style="margin-top: var(--space-2); width: 100%; padding: 14px;">
                    {{ __('auth.login_button') }}
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-left: 4px;"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3"/></svg>
                </button>
            </form>

            <div style="text-align: center; margin-top: var(--space-4); border-top: 1px solid var(--color-outline-variant); padding-top: var(--space-3);">
                <p style="color: var(--color-on-surface-variant); font-size: 0.875rem;">
                    {{ __('auth.no_account') }} 
                    <a href="{{ route('register') }}" style="color: var(--color-primary); font-weight: 600; text-decoration: none;">{{ __('auth.register_link') }}</a>
                </p>
            </div>

            @if (app()->environment('local', 'development'))
            <div style="margin-top: var(--space-4); background: rgba(245, 158, 11, 0.08); border: 1px solid rgba(245, 158, 11, 0.2); border-radius: var(--radius-lg); padding: var(--space-3); text-align: left;">
                <p style="font-size: 0.7rem; font-weight: 600; color: var(--color-warning); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.05em;">{{ __('auth.dev_info') }}</p>
                <div style="font-size: 0.75rem; color: var(--color-on-surface-variant); line-height: 1.8;">
                    <div><span style="color: var(--color-primary); font-weight: 600;">{{ __('auth.dev_admin') }}</span> &mdash; admin@publikdigital.id / <strong style="color: var(--color-on-surface);">{{ __('auth.dev_password') }}</strong></div>
                    <div><span style="color: var(--color-on-surface); font-weight: 600;">{{ __('auth.dev_buyer') }}</span> &mdash; test@example.com / <strong style="color: var(--color-on-surface);">{{ __('auth.dev_password') }}</strong></div>
                </div>
            </div>
            @endif

        </div>
    </div>
</section>
@endsection
