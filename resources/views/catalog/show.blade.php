@extends('layouts.marketplace')

@section('title', $product->name)
@section('meta_description', $product->short_description ?? Str::limit(strip_tags($product->description), 160))

@push('meta')
    @if(isset($ogImage) && $ogImage)
        <meta property="og:image" content="{{ $ogImage }}">
        <meta name="twitter:image" content="{{ $ogImage }}">
    @endif
@endpush

@push('styles')
<style>
.star-input { display: none; }
.star-label { cursor: pointer; font-size: 1.5rem; color: var(--color-outline-variant); transition: color 0.2s; }
.star-label:hover, .star-label:hover ~ .star-label,
.star-input:checked ~ .star-label { color: var(--color-warning); }
.rating-group { display: flex; flex-direction: row-reverse; justify-content: flex-end; gap: 2px; }
</style>
@endpush

@section('content')
<section style="padding-top: 100px;">
    <div class="container">
        <div style="display:grid; grid-template-columns:1.2fr 1fr; gap:var(--space-6); align-items:start;">
            {{-- Product Image --}}
            <div>
                <div style="border-radius:var(--radius-lg); overflow:hidden; background:var(--color-surface-container);">
                    @if($product->getThumbnailUrl())
                        <img src="{{ $product->getThumbnailUrl() }}" alt="{{ $product->name }}" style="width:100%; display:block;">
                    @else
                        <div style="aspect-ratio:4/3; display:flex; align-items:center; justify-content:center; background:var(--color-surface-container-high);">
                            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="var(--color-outline)" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Product Info --}}
            <div>
                <div style="display:flex; align-items:center; justify-content:space-between;">
                    <a href="{{ route('catalog.index', ['category' => $product->category->slug ?? '']) }}" class="chip chip-primary" style="margin-bottom:16px;">
                        {{ $product->category->name ?? __('marketplace.product_uncategorized') }}
                    </a>
                    @auth
                        @php $isWishlisted = in_array($product->id, $wishlistIds ?? []); @endphp
                        <button type="button" onclick="toggleWishlist({{ $product->id }}, this)" style="background:none; border:none; cursor:pointer; padding:8px; color:{{ $isWishlisted ? 'var(--color-error)' : 'var(--color-outline)' }}; transition:color 0.2s; margin-bottom:16px;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="{{ $isWishlisted ? 'var(--color-error)' : 'none' }}" stroke="currentColor" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                        </button>
                    @endauth
                </div>

                <h1 class="display-lg" style="font-size:2.5rem; margin-bottom:var(--space-2);">{{ $product->name }}</h1>

                {{-- Rating display --}}
                @if($product->review_count > 0)
                    <div style="display:flex; align-items:center; gap:6px; margin-bottom:var(--space-2);">
                        @for($i = 1; $i <= 5; $i++)
                            <span style="font-size:1rem; color:{{ $i <= round($product->rating) ? 'var(--color-warning)' : 'var(--color-outline-variant)' }};">&#9733;</span>
                        @endfor
                        <span style="font-size:0.8rem; color:var(--color-on-surface-variant);">{{ number_format($product->rating, 1) }} ({{ $product->review_count }} {{ __('marketplace.product_reviews') }})</span>
                    </div>
                @endif

                @if($product->short_description)
                    <p class="body-lg" style="color:var(--color-on-surface-variant); margin-bottom:var(--space-4);">{{ $product->short_description }}</p>
                @endif

                {{-- Price --}}
                <div style="display:flex; align-items:baseline; gap:12px; margin-bottom:var(--space-4);">
                    <span style="font-family:var(--font-headline); font-size:2rem; font-weight:700; color:var(--color-primary);">
                        Rp {{ number_format($product->effective_price, 0, ',', '.') }}
                    </span>
                    @if($product->is_on_sale)
                        <span style="text-decoration:line-through; color:var(--color-on-surface-variant); font-size:1.125rem;">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                        <span class="chip" style="background:rgba(255,181,154,0.15); color:var(--color-tertiary); border:none; font-size:0.7rem;">
                            {{ __('marketplace.product_discount') }} {{ round((1 - $product->effective_price / $product->price) * 100) }}%
                        </span>
                    @endif
                </div>

                {{-- Stats --}}
                <div style="display:flex; gap:var(--space-4); margin-bottom:var(--space-4); padding:var(--space-2) 0; border-top:1px solid var(--color-outline-variant); border-bottom:1px solid var(--color-outline-variant);">
                    <div class="label-md" style="color:var(--color-on-surface-variant);">
                        <span style="color:var(--color-on-surface); font-weight:700;">{{ $product->download_count }}</span> {{ __('marketplace.product_downloads') }}
                    </div>
                    <div class="label-md" style="color:var(--color-on-surface-variant);">
                        <span style="color:var(--color-on-surface); font-weight:700;">{{ $product->view_count }}</span> {{ __('marketplace.product_views') }}
                    </div>
                    <div class="label-md" style="color:var(--color-on-surface-variant);">
                        {{ __('marketplace.product_type') }} <span style="color:var(--color-primary); font-weight:600;">{{ ucfirst($product->type) }}</span>
                    </div>
                </div>

                {{-- Actions --}}
                <div style="display:flex; gap:12px; margin-bottom:var(--space-4);">
                    <form action="{{ route('cart.add', $product) }}" method="POST" style="flex:1;">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn btn-primary btn-lg btn-pill" style="width:100%;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:6px;"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            {{ __('marketplace.product_buy') }}
                        </button>
                    </form>
                    @if($product->demo_url)
                        <a href="{{ $product->demo_url }}" target="_blank" class="btn btn-secondary btn-lg btn-pill">{{ __('marketplace.product_demo') }}</a>
                    @endif
                    <a href="{{ route('chat.start', $product) }}" class="btn btn-secondary btn-lg btn-pill">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:6px;"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        {{ __('marketplace.product_ask') }}
                    </a>
                </div>

                {{-- Tags --}}
                @if($product->tags && count($product->tags))
                    <div style="display:flex; flex-wrap:wrap; gap:8px; margin-top:var(--space-2);">
                        @foreach($product->tags as $tag)
                            <span class="chip" style="background:var(--color-surface-container-high); color:var(--color-on-surface-variant); border:none; font-size:0.7rem;">{{ $tag }}</span>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Description --}}
        <div style="margin-top:var(--space-8); max-width:800px;">
            <h2 class="headline-sm" style="margin-bottom:var(--space-3);">{{ __('marketplace.product_description') }}</h2>
            <div class="body-md" style="color:var(--color-on-surface-variant); line-height:1.8;">
                {!! $product->description !!}
            </div>
        </div>

        {{-- Reviews Section --}}
        <div style="margin-top:var(--space-8); max-width:800px;" id="reviews">
            <h2 class="headline-sm" style="margin-bottom:var(--space-4);">
                {{ __('marketplace.product_reviews_heading') }} ({{ $product->review_count }})
            </h2>

            @auth
                @php
                    $hasPurchased = \App\Models\OrderItem::whereHas('order', function ($q) {
                        $q->where('user_id', auth()->id())
                            ->where(function ($q2) {
                                $q2->where('payment_status', 'paid')->orWhere('status', 'completed');
                            });
                    })->where('product_id', $product->id)->exists();

                    $userReview = $product->reviews()->where('user_id', auth()->id())->first();
                @endphp

                @if($hasPurchased)
                    <div style="background:var(--color-surface-container); border:1px solid var(--color-outline-variant); border-radius:var(--radius-lg); padding:var(--space-4); margin-bottom:var(--space-4);" id="review-form">
                        <h3 style="font-family:var(--font-headline); font-size:1rem; font-weight:600; margin-bottom:var(--space-3);">
                            {{ $userReview ? __('marketplace.product_edit_review') : __('marketplace.product_write_review') }}
                        </h3>

                        @if(session('success'))
                            <div style="color:var(--color-success); font-size:0.875rem; margin-bottom:12px;">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('review.store', $product) }}" method="POST">
                            @csrf
                            <div class="rating-group" style="margin-bottom:12px;">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" class="star-input" {{ $userReview && $userReview->rating == $i ? 'checked' : '' }}>
                                    <label for="star{{ $i }}" class="star-label" title="{{ $i }} {{ __('marketplace.product_review_stars') }}">&#9733;</label>
                                @endfor
                            </div>
                            @error('rating')
                                <span style="color:var(--color-error); font-size:0.75rem; display:block; margin-bottom:8px;">{{ $message }}</span>
                            @enderror

                            <textarea name="review" rows="3" class="input-field" placeholder="{{ __('marketplace.product_review_placeholder') }}" style="margin-bottom:12px;">{{ $userReview->review ?? '' }}</textarea>
                            @error('review')
                                <span style="color:var(--color-error); font-size:0.75rem; display:block; margin-bottom:8px;">{{ $message }}</span>
                            @enderror

                            <button type="submit" class="btn btn-primary" style="padding: 10px 24px; font-size:0.85rem;">{{ $userReview ? __('marketplace.product_review_update') : __('marketplace.product_review_submit') }}</button>
                        </form>
                    </div>
                @else
                    <p style="font-size:0.875rem; color:var(--color-on-surface-variant); margin-bottom:var(--space-4);">{{ __('marketplace.product_review_buy_first') }}</p>
                @endif
            @else
<p style="font-size:0.875rem; color:var(--color-on-surface-variant); margin-bottom:var(--space-4);">
    {!! str_replace(
        __('marketplace.product_review_login'),
        '<a href="'.route('login').'" style="color:var(--color-primary);">'.__('marketplace.product_review_login').'</a>',
        __('marketplace.product_review_login_prompt')
    ) !!}
</p>
            @endauth

            {{-- Reviews List --}}
            @php
                $reviews = $product->reviews()->with('user')->approved()->latest()->get();
            @endphp

            @forelse($reviews as $review)
                <div style="background:var(--color-surface-container); border:1px solid var(--color-outline-variant); border-radius:var(--radius-md); padding:var(--space-3); margin-bottom:12px;">
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:6px;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div style="width:32px; height:32px; border-radius:50%; background:var(--color-surface-container-high); display:flex; align-items:center; justify-content:center; font-weight:600; font-size:0.8rem; color:var(--color-on-surface);">
                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p style="font-size:0.85rem; font-weight:600; color:var(--color-on-surface);">{{ $review->user->name }}</p>
                                <p style="font-size:0.7rem; color:var(--color-on-surface-variant);">{{ $review->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div style="display:flex; gap:2px;">
                            @for($i = 1; $i <= 5; $i++)
                                <span style="font-size:0.85rem; color:{{ $i <= $review->rating ? 'var(--color-warning)' : 'var(--color-outline-variant)' }};">&#9733;</span>
                            @endfor
                        </div>
                    </div>
                    @if($review->review)
                        <p style="font-size:0.85rem; color:var(--color-on-surface-variant); line-height:1.6;">{{ $review->review }}</p>
                    @endif
                </div>
            @empty
                <p style="font-size:0.875rem; color:var(--color-on-surface-variant); text-align:center; padding:var(--space-4);">{{ __('marketplace.product_reviews_empty') }}</p>
            @endforelse
        </div>

        {{-- Related Products --}}
        @if($relatedProducts->count())
            <div style="margin-top:var(--space-10);">
                <h2 class="headline-sm" style="margin-bottom:var(--space-4);">{{ __('marketplace.product_related') }}</h2>
                <div class="grid-products">
                    @foreach($relatedProducts as $related)
                        @include('components.product-card', ['product' => $related])
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Recently Viewed --}}
        @if(count($recentlyViewed) > 0)
            <div style="margin-top:var(--space-10);">
                <h2 class="headline-sm" style="margin-bottom:var(--space-4);">{{ __('marketplace.product_recently_viewed') }}</h2>
                <div class="grid-products">
                    @foreach($recentlyViewed as $rv)
                        @include('components.product-card', ['product' => $rv])
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
<div style="height:var(--space-10);"></div>
@endsection

@push('scripts')
<script>
function toggleWishlist(productId, btn) {
    fetch('/wishlist/toggle/' + productId, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => {
        const svg = btn.querySelector('svg');
        if (data.wishlisted) {
            svg.setAttribute('fill', 'var(--color-error)');
            btn.style.color = 'var(--color-error)';
        } else {
            svg.setAttribute('fill', 'none');
            btn.style.color = 'var(--color-outline)';
        }
    });
}
</script>
@endpush
