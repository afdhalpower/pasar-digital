@extends('layouts.marketplace')

@section('title', __('marketplace.contact_title'))
@section('meta_description', 'Hubungi tim PublikDigital untuk pertanyaan, saran, atau kerja sama.')

@section('content')
<section class="section" style="padding-top:120px;">
    <div class="container" style="max-width:720px;">
        <div style="text-align:center; margin-bottom:var(--space-6);">
            <span class="hero-badge">{{ __('marketplace.contact_badge') }}</span>
            <h1 class="headline-sm" style="margin-top:var(--space-2);">{{ __('marketplace.contact_heading') }}</h1>
            <p class="hero-subtitle" style="margin:var(--space-2) auto 0;">{{ __('marketplace.contact_subtitle') }}</p>
        </div>

        @if(session('success'))
            <div style="background:rgba(16,185,129,0.1); border:1px solid var(--color-success); border-radius:var(--radius-md); padding:var(--space-3); margin-bottom:var(--space-4); text-align:center;">
                <p style="color:var(--color-success); font-size:0.875rem; font-weight:500;">{{ session('success') }}</p>
            </div>
        @endif

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:var(--space-6);">
            <div style="display:flex; flex-direction:column; gap:var(--space-4);">
                <div style="background:var(--color-surface-container); border:1px solid var(--color-outline-variant); border-radius:var(--radius-lg); padding:var(--space-3);">
                    <h3 style="font-weight:600; margin-bottom:var(--space-1);">{{ __('marketplace.contact_email') }}</h3>
                    <p style="color:var(--color-on-surface-variant); font-size:0.875rem;">hello@publikdigital.id</p>
                </div>
                <div style="background:var(--color-surface-container); border:1px solid var(--color-outline-variant); border-radius:var(--radius-lg); padding:var(--space-3);">
                    <h3 style="font-weight:600; margin-bottom:var(--space-1);">{{ __('marketplace.contact_hours') }}</h3>
                    <p style="color:var(--color-on-surface-variant); font-size:0.875rem;">{{ __('marketplace.contact_hours_value') }}</p>
                </div>
                <div style="background:var(--color-surface-container); border:1px solid var(--color-outline-variant); border-radius:var(--radius-lg); padding:var(--space-3);">
                    <h3 style="font-weight:600; margin-bottom:var(--space-1);">{{ __('marketplace.contact_chat') }}</h3>
                    <p style="color:var(--color-on-surface-variant); font-size:0.875rem;">{{ __('marketplace.contact_chat_info') }}</p>
                </div>
            </div>
            <div style="background:var(--color-surface-container); border:1px solid var(--color-outline-variant); border-radius:var(--radius-lg); padding:var(--space-4);">
                <h3 style="font-weight:600; margin-bottom:var(--space-3);">{{ __('marketplace.contact_form_heading') }}</h3>
                <form action="{{ route('contact') }}" method="POST">
                    @csrf
                    <div style="display:flex; flex-direction:column; gap:var(--space-2);">
                        <input type="text" name="name" placeholder="{{ __('marketplace.contact_name') }}" class="input-field @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name') <span style="color:var(--color-error); font-size:0.75rem;">{{ $message }}</span> @enderror

                        <input type="email" name="email" placeholder="{{ __('marketplace.contact_email_field') }}" class="input-field @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        @error('email') <span style="color:var(--color-error); font-size:0.75rem;">{{ $message }}</span> @enderror

                        <input type="text" name="subject" placeholder="{{ __('marketplace.contact_subject') }}" class="input-field @error('subject') is-invalid @enderror" value="{{ old('subject') }}" required>
                        @error('subject') <span style="color:var(--color-error); font-size:0.75rem;">{{ $message }}</span> @enderror

                        <textarea name="message" rows="4" placeholder="{{ __('marketplace.contact_message') }}" class="input-field @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                        @error('message') <span style="color:var(--color-error); font-size:0.75rem;">{{ $message }}</span> @enderror

                        <button type="submit" class="btn btn-primary btn-pill">{{ __('marketplace.contact_submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
