<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'PublikDigital - Marketplace produk digital premium untuk kreator Indonesia')">
    <title>@yield('title', 'PublikDigital') — Marketplace Digital Premium</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/design-system.css')
    @stack('styles')
</head>
<body>
    {{-- Glass Navigation Bar --}}
    <nav class="nav-glass" id="mainNav">
        <div class="container nav-inner">
            <a href="{{ route('home') }}" class="nav-brand">PublikDigital</a>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a></li>
                <li><a href="{{ route('catalog.index') }}" class="{{ request()->routeIs('catalog.*') ? 'active' : '' }}">Katalog</a></li>
                <li><a href="#" class="">Tentang</a></li>
            </ul>
            <div class="nav-links">
                @auth
                    <a href="{{ route('chat.index') }}" class="btn btn-secondary" style="padding:8px 16px; position:relative;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        @if(isset($unreadCount) && $unreadCount > 0)
                            <span style="position:absolute; top:-4px; right:-4px; background:var(--color-error); color:#fff; font-size:0.65rem; font-weight:700; width:18px; height:18px; border-radius:50%; display:flex; align-items:center; justify-content:center;">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('cart.index') }}" class="btn btn-secondary" style="padding:8px 16px; position:relative;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        @if($cartCount > 0)
                            <span style="position:absolute; top:-4px; right:-4px; background:var(--color-primary); color:var(--color-on-primary); font-size:0.65rem; font-weight:700; width:18px; height:18px; border-radius:50%; display:flex; align-items:center; justify-content:center;">{{ $cartCount > 99 ? '99+' : $cartCount }}</span>
                        @endif
                    </a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ url('/admin') }}" class="btn btn-secondary" style="padding:8px 20px;">Dashboard</a>
                    @else
                        <a href="{{ route('buyer.dashboard') }}" class="btn btn-secondary" style="padding:8px 20px;">Pesanan Saya</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary" style="padding:8px 20px;">Masuk</a>
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
                    <div class="footer-brand">PublikDigital</div>
                    <p style="color: var(--color-on-surface-variant); font-size: 0.875rem; max-width: 320px;">
                        Marketplace produk digital premium untuk kreator Indonesia. Temukan template, software, dan aset digital berkualitas tinggi.
                    </p>
                </div>
                <div>
                    <h4>Produk</h4>
                    <a href="{{ route('catalog.index', ['type' => 'template']) }}">Template</a>
                    <a href="{{ route('catalog.index', ['type' => 'software']) }}">Software</a>
                    <a href="{{ route('catalog.index', ['type' => 'digital']) }}">Digital</a>
                    <a href="{{ route('catalog.index', ['type' => 'asset']) }}">Asset</a>
                </div>
                <div>
                    <h4>Perusahaan</h4>
                    <a href="{{ route('about') }}">Tentang Kami</a>
                    <a href="{{ route('careers') }}">Karir</a>
                    <a href="{{ route('blog') }}">Blog</a>
                </div>
                <div>
                    <h4>Bantuan</h4>
                    <a href="{{ route('faq') }}">FAQ</a>
                    <a href="{{ route('contact') }}">Kontak</a>
                    <a href="{{ route('privacy') }}">Kebijakan Privasi</a>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; {{ date('Y') }} PublikDigital. Semua hak dilindungi.
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
