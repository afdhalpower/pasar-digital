<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', __('marketplace.meta_description'))">
    <meta name="keywords" content="produk digital, template, software, UI kit, marketpace Indonesia, download template, aset digital">
    <link rel="canonical" href="{{ url()->current() }}">
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@type": "Organization",
        "name": "PublikDigital",
        "url": "{{ url('/') }}",
        "description": "Marketplace produk digital premium untuk kreator Indonesia."
    }
    </script>
    <meta property="og:title" content="@yield('title', __('marketplace.brand')) — {{ __('marketplace.title_suffix') }}">
    <meta property="og:description" content="@yield('meta_description', __('marketplace.og_description'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ __('marketplace.brand') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', __('marketplace.brand')) — {{ __('marketplace.title_suffix') }}">
    <meta name="twitter:description" content="@yield('meta_description', __('marketplace.og_description'))">
    <title>@yield('title', __('marketplace.brand')) — {{ __('marketplace.title_suffix') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/css/design-system.css')
    @stack('meta')
    @stack('styles')
</head>
<body>
    {{-- Toast Notification --}}
    <x-toast />

    {{-- Glass Navigation Bar --}}
    <nav class="nav-glass" id="mainNav" x-data="{ mobileOpen: false }">
        <div class="container nav-inner">
            <a href="{{ route('home') }}" class="nav-brand">{{ __('marketplace.brand') }}</a>
            <button class="nav-toggle" @click="mobileOpen = !mobileOpen" aria-label="{{ __('marketplace.nav_toggle') }}">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <template x-if="!mobileOpen">
                        <path d="M3 12h18M3 6h18M3 18h18"/>
                    </template>
                    <template x-if="mobileOpen">
                        <path d="M18 6L6 18M6 6l12 12"/>
                    </template>
                </svg>
            </button>
            <ul class="nav-links" :class="{ 'is-open': mobileOpen }" @click.away="mobileOpen = false">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">{{ __('marketplace.nav_home') }}</a></li>
                <li><a href="{{ route('catalog.index') }}" class="{{ request()->routeIs('catalog.*') ? 'active' : '' }}">{{ __('marketplace.nav_catalog') }}</a></li>
                <li><a href="{{ route('catalog.bundles') }}" class="bundle-nav-link {{ request()->routeIs('catalog.bundles') ? 'active' : '' }}">{{ __('marketplace.nav_bundles') }}</a></li>
                <li class="nav-search-item">
                    <form action="{{ route('catalog.index') }}" method="GET" style="display:flex;">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('marketplace.nav_search') }}" class="input-field" style="padding:6px 12px; font-size:0.8rem; min-width:200px;" aria-label="{{ __('marketplace.nav_search') }}">
                    </form>
                </li>
                @auth
                    <li class="nav-mobile-only"><a href="{{ route('chat.index') }}">{{ __('marketplace.nav_messages') }}</a></li>
                    <li class="nav-mobile-only"><a href="{{ route('cart.index') }}">{{ __('marketplace.nav_cart') }}</a></li>
                    @if(auth()->user()->isAdmin())
                        <li class="nav-mobile-only"><a href="{{ url('/admin') }}">{{ __('marketplace.nav_admin') }}</a></li>
                    @else
                        <li class="nav-mobile-only"><a href="{{ route('buyer.dashboard') }}">{{ __('marketplace.nav_dashboard') }}</a></li>
                        <li class="nav-mobile-only"><a href="{{ route('buyer.orders') }}">{{ __('marketplace.nav_orders') }}</a></li>
                    @endif
                    <li class="nav-mobile-only">
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('marketplace.nav_logout') }}</a>
                        <form id="logout-form" action="{{ route('buyer.logout') }}" method="POST" style="display:none;">@csrf</form>
                    </li>
                @else
                    <li class="nav-mobile-only"><a href="{{ route('login') }}">{{ __('marketplace.nav_login') }}</a></li>
                    <li class="nav-mobile-only"><a href="{{ route('register') }}">{{ __('marketplace.nav_register') }}</a></li>
                @endauth
            </ul>
            <div class="nav-actions">
                @auth
                    <a href="{{ route('chat.index') }}" class="btn btn-secondary" style="padding:8px 16px; position:relative;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        @if(isset($unreadCount) && $unreadCount > 0)
                            <span style="position:absolute; top:-4px; right:-4px; background:var(--color-error); color:#fff; font-size:0.65rem; font-weight:700; width:18px; height:18px; border-radius:50%; display:flex; align-items:center; justify-content:center;">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('cart.index') }}" class="btn btn-secondary" style="padding:8px 16px; position:relative;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        @if(isset($cartCount) && $cartCount > 0)
                            <span style="position:absolute; top:-4px; right:-4px; background:var(--color-primary); color:var(--color-on-primary); font-size:0.65rem; font-weight:700; width:18px; height:18px; border-radius:50%; display:flex; align-items:center; justify-content:center;">{{ $cartCount > 99 ? '99+' : $cartCount }}</span>
                        @endif
                    </a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ url('/admin') }}" class="btn btn-secondary" style="padding:8px 20px;">{{ __('marketplace.nav_admin') }}</a>
                    @else
                        <a href="{{ route('buyer.dashboard') }}" class="btn btn-secondary" style="padding:8px 20px;">{{ __('marketplace.nav_orders') }}</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary" style="padding:8px 20px;">{{ __('marketplace.nav_login') }}</a>
                @endauth
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="footer-brand">{{ __('marketplace.brand') }}</div>
                    <p style="color: var(--color-on-surface-variant); font-size: 0.875rem; max-width: 320px;">
                        {{ __('marketplace.footer_description') }}
                    </p>
                </div>
                <div>
                    <h4>{{ __('marketplace.footer_products') }}</h4>
                    <a href="{{ route('catalog.index', ['type' => 'template']) }}">{{ __('marketplace.footer_template') }}</a>
                    <a href="{{ route('catalog.index', ['type' => 'software']) }}">{{ __('marketplace.footer_software') }}</a>
                    <a href="{{ route('catalog.index', ['type' => 'digital']) }}">{{ __('marketplace.footer_digital') }}</a>
                    <a href="{{ route('catalog.index', ['type' => 'asset']) }}">{{ __('marketplace.footer_asset') }}</a>
                </div>
                <div>
                    <h4>{{ __('marketplace.footer_company') }}</h4>
                    <a href="{{ route('about') }}">{{ __('marketplace.footer_about') }}</a>
                    <a href="{{ route('careers') }}">{{ __('marketplace.footer_careers') }}</a>
                    <a href="{{ route('blog') }}">{{ __('marketplace.footer_blog') }}</a>
                </div>
                <div>
                    <h4>{{ __('marketplace.footer_help') }}</h4>
                    <a href="{{ route('faq') }}">{{ __('marketplace.footer_faq') }}</a>
                    <a href="{{ route('contact') }}">{{ __('marketplace.footer_contact') }}</a>
                    <a href="{{ route('privacy') }}">{{ __('marketplace.footer_privacy') }}</a>
                    <a href="{{ route('terms') }}">{{ __('marketplace.footer_terms') }}</a>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; {{ date('Y') }} {{ __('marketplace.brand') }}. {{ __('marketplace.footer_copyright') }}
            </div>
        </div>
    </footer>

    <script>
        // Glass nav scroll effect
        window.addEventListener('scroll', () => {
            document.getElementById('mainNav')?.classList.toggle('scrolled', window.scrollY > 20);
        });
    </script>
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
    @stack('scripts')
</body>
</html>
