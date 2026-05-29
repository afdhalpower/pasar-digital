@extends('layouts.marketplace')

@section('title', __('marketplace.chat_title'))

@section('content')
<section class="section" style="padding-top:100px; min-height:80vh;">
    <div class="container">
        <h1 class="headline-sm" style="margin-bottom:var(--space-4);">{{ __('marketplace.chat_title') }}</h1>

        @if($conversations->isEmpty())
            <div style="text-align:center; padding:var(--space-8) 0; color:var(--color-on-surface-variant);">
                <p class="body-lg" style="margin-bottom:var(--space-3);">{{ __('marketplace.chat_empty') }}</p>
                <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-pill">{{ __('marketplace.chat_empty_cta') }}</a>
            </div>
        @else
            <div class="conversation-list">
                @foreach($conversations as $conv)
                    @php
                        $lastMsg = $conv->lastMessage;
                        $unread = Auth::user()->isAdmin()
                            ? $conv->unreadForAdmin()
                            : $conv->unreadForBuyer();
                    @endphp
                    <a href="{{ route('chat.show', $conv) }}" class="conversation-card {{ $unread > 0 ? 'has-unread' : '' }}">
                        <div class="conversation-avatar">{{ strtoupper(substr($conv->buyer->name, 0, 1)) }}</div>
                        <div class="conversation-body">
                            <div class="conversation-header">
                                <span class="conversation-name">{{ $conv->buyer->name }}</span>
                                @if($lastMsg)
                                    <span class="conversation-time">{{ $lastMsg->created_at->diffForHumans() }}</span>
                                @endif
                            </div>
                            @if($conv->product)
                                <div class="conversation-product">{{ $conv->product->name }}</div>
                            @endif
                            <div class="conversation-preview">
                                @if($lastMsg)
                                    @if($lastMsg->image && !$lastMsg->body)
                                        <span class="conversation-image-indicator">📷 {{ __('marketplace.chat_image') }}</span>
                                    @else
                                        {{ Str::limit($lastMsg->body, 60) }}
                                    @endif
                                @else
                                    <span style="color:var(--color-outline);">{{ __('marketplace.chat_no_messages') }}</span>
                                @endif
                            </div>
                        </div>
                        @if($unread > 0)
                            <div class="conversation-badge">{{ $unread > 99 ? '99+' : $unread }}</div>
                        @endif
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
