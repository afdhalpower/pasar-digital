<aside style="background: var(--color-surface-container); border: 1px solid var(--color-outline-variant); padding: var(--space-4); border-radius: var(--radius-lg); height: fit-content;" class="dashboard-sidebar">
    <div style="display: flex; align-items: center; gap: 12px; padding-bottom: var(--space-3); border-bottom: 1px solid var(--color-outline-variant); margin-bottom: var(--space-3);">
        <div style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--color-teal-brand) 0%, var(--color-primary) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 1.25rem; box-shadow: var(--shadow-md);">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <div>
            <h3 style="font-size: 1rem; font-weight: 600; color: var(--color-on-surface); word-break: break-all;">{{ auth()->user()->name }}</h3>
            <span style="font-size: 0.75rem; color: var(--color-on-surface-variant);">Pembeli</span>
        </div>
    </div>
    
    <nav style="display: flex; flex-direction: column; gap: 8px;">
        <a href="{{ route('buyer.dashboard') }}" class="dashboard-nav-link {{ request()->routeIs('buyer.dashboard') ? 'active' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:8px;"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg>
            Ringkasan
        </a>
        <a href="{{ route('buyer.orders') }}" class="dashboard-nav-link {{ request()->routeIs('buyer.orders') || request()->routeIs('buyer.order.detail') || request()->routeIs('buyer.order.confirmation') ? 'active' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:8px;"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            Riwayat Pesanan
        </a>
        <a href="{{ route('buyer.downloads') }}" class="dashboard-nav-link {{ request()->routeIs('buyer.downloads') ? 'active' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:8px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
            Produk Saya
        </a>
        <a href="{{ route('buyer.wishlist') }}" class="dashboard-nav-link {{ request()->routeIs('buyer.wishlist') ? 'active' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:8px;"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            Produk Favorit
        </a>
        <a href="{{ route('buyer.profile') }}" class="dashboard-nav-link {{ request()->routeIs('buyer.profile') ? 'active' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:8px;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Pengaturan Profil
        </a>
        <div style="border-top: 1px solid var(--color-outline-variant); margin-top: var(--space-2); padding-top: var(--space-2);">
            <a href="{{ route('buyer.logout') }}" class="dashboard-nav-link text-error">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:8px;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                Keluar
            </a>
        </div>
    </nav>
</aside>
