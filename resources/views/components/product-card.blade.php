<a href="{{ route('catalog.show', $product->slug) }}" class="product-card" id="product-{{ $product->id }}">
    @if($product->getThumbnailUrl())
        <img src="{{ $product->getThumbnailUrl() }}" alt="{{ $product->name }}" loading="lazy">
    @else
        <div style="aspect-ratio:4/3; background:var(--color-surface-container-high); display:flex; align-items:center; justify-content:center;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--color-outline)" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
        </div>
    @endif
    <div class="product-card-body">
        <div class="product-card-category">{{ $product->category->name ?? 'Uncategorized' }}</div>
        <h3 class="product-card-title">{{ $product->name }}</h3>
        @if($product->short_description)
            <p class="body-md" style="color:var(--color-on-surface-variant); margin-bottom:12px; font-size:0.85rem; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                {{ $product->short_description }}
            </p>
        @endif
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div class="product-card-price">
                Rp {{ number_format($product->effective_price, 0, ',', '.') }}
                @if($product->is_on_sale)
                    <span class="original">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                @endif
            </div>
            @auth
                @php $isWishlisted = in_array($product->id, $wishlistIds ?? []); @endphp
                <button type="button" onclick="event.preventDefault(); event.stopPropagation(); toggleWishlist({{ $product->id }}, this)" style="background:none; border:none; cursor:pointer; padding:4px; color:{{ $isWishlisted ? 'var(--color-error)' : 'var(--color-outline)' }}; transition:color 0.2s;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="{{ $isWishlisted ? 'var(--color-error)' : 'none' }}" stroke="currentColor" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                </button>
            @endauth
        </div>
        @if($product->rating > 0)
            <div style="margin-top: 8px; display: flex; align-items: center; gap: 4px;">
                @for($i = 1; $i <= 5; $i++)
                    <span style="font-size: 0.75rem; color: {{ $i <= round($product->rating) ? 'var(--color-warning)' : 'var(--color-outline-variant)' }};">&#9733;</span>
                @endfor
                <span style="font-size: 0.65rem; color: var(--color-on-surface-variant);">({{ $product->review_count }})</span>
            </div>
        @endif
    </div>
</a>
