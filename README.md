# PublikDigital — Premium Digital Product Marketplace

**PublikDigital** adalah platform marketplace produk digital premium untuk kreator, developer, dan desainer Indonesia. Dibangun dengan **Laravel 13** + **Filament v5**, mengadaptasi token desain **Google Stitch**.

---

## Fitur Utama

### Marketplace (Frontend)
- **Katalog Produk** — Grid produk digital dengan filter kategori, search, pagination, wishlist indicator
- **Wishlist (Favorit)** — Toggle via AJAX tanpa reload, halaman grid produk terpisah di dashboard
- **Review & Rating** — Bintang 1–5 + komentar oleh pembeli terverifikasi, edit review, aggregate rating otomatis
- **Keranjang Belanja** — Cart berbasis database (tabel `cart_items`), add/update/remove/checkout
- **Checkout & Konfirmasi** — Manual transfer bank + kode unik (1–999) untuk verifikasi admin
- **Dashboard Pembeli** — Riwayat pesanan dengan filter & search, detail pesanan (timeline 4-step), download produk digital (pagination 12/page), profil
- **Chat In-App** — Tanya jawab buyer-admin tiap produk, dukungan teks + gambar

### Admin Panel (Filament v5)
- **Dashboard Stats** — 8 kartu statistik (total revenue, bulan ini, pending, total buyers, produk, kategori, pesanan, download)
- **Grafik Penjualan** — Line chart 30 hari pendapatan
- **Quick Actions** — 4 tombol cepat (Tambah Produk, Pesanan, Kategori, Pengguna)
- **Widget Pesanan** — 5 pesanan terbaru + link edit
- **Widget Pembeli** — Top 5 pembeli (by order count)
- **Manajemen CRUD** — Produk, Kategori, Pesanan, Pengguna
- **Detail Pesanan** — Infolist items + ringkasan keuangan (subtotal, kode unik, total transfer)
- **Quick Actions Order** — 4 tombol aksi (Set Lunas, Set Selesai, Proses Pesanan, Batalkan)
- **Chat Admin** — Lihat & balas percakapan, mulai chat baru ke buyer
- **Login Page** — Kartu kredensial dev (admin + buyer) di environment lokal

### Design System
- **Dark Mode** — Palet gelap `#111415` + aksen Teal `#6BD8CB`
- **Glassmorphism** — Navbar transparan dengan `backdrop-filter: blur(12px)`
- **Typography** — Playfair Display (headline) + Inter (body)
- **Micro-Interactions** — Shimmer effect, GPU-accelerated scale, glow shadows
- **CSS Variables** — Semua visual dashboard via `design-system.css`, zero inline `<style>`

---

## Spesifikasi Teknologi

| Layer | Teknologi | Versi |
|---|---|---|
| **Core** | Laravel | 13.x |
| **PHP** | PHP | 8.4+ |
| **Admin Panel** | Filament | v5.x |
| **CSS** | Vanilla CSS (CSS Variables) | — |
| **Build** | Vite | — |
| **Database** | SQLite | — |
| **Fonts** | Google Fonts | Playfair Display + Inter |
| **Media** | Spatie Media Library | — |

---

## Struktur Folder

```text
republikdigital/
├── DESIGN.md
├── app/
│   ├── Filament/
│   │   ├── Resources/           # Category, Product, Order, User, Conversation
│   │   └── Widgets/             # StatsOverview, TopProducts, QuickActions, SalesChart, RecentOrders, TopBuyers
│   └── Http/Controllers/
│       ├── Buyer/               # BuyerDashboardController (orders, downloads, wishlist, reviews, profile)
│       ├── HomeController.php
│       ├── CatalogController.php
│       ├── CartController.php
│       └── ChatController.php
├── database/
│   └── migrations/
├── resources/
│   ├── css/design-system.css
│   └── views/
│       ├── layouts/
│       ├── catalog/
│       ├── cart/
│       ├── chat/
│       ├── buyer/               # dashboard, orders, order-detail, downloads, wishlist, profile, sidebar
│       ├── components/           # product-card (with wishlist heart + star rating)
│       ├── filament/             # custom chat page blade
│       └── pages/                # footer pages (about, careers, blog, faq, contact, privacy)
└── routes/web.php
```

---

## Instalasi

```bash
# Prasyarat: PHP 8.4+, Composer, Node.js

git clone <repo>
cd republikdigital

composer install
npm install

cp .env.example .env
# edit .env jika perlu

touch database/database.sqlite
php artisan migrate --seed

# Storage link untuk upload gambar
php artisan storage:link

# Build assets
npm run build

# Jalankan server
php artisan serve
```

## Login

### Admin
- **URL**: `http://localhost:8000/admin/login`
- **Email**: `admin@publikdigital.id`
- **Password**: `password`

### Buyer (dummy)
- **URL**: `http://localhost:8000/login`
- **Email**: `buyer@publikdigital.id`
- **Password**: `password`

> Di environment lokal, halaman login menampilkan kartu kredensial dev.

---

## Rute Penting

| Path | Deskripsi |
|---|---|
| `/` | Beranda |
| `/katalog` | Katalog produk |
| `/produk/{slug}` | Detail produk (wishlist toggle + review) |
| `/cart` | Keranjang belanja |
| `/chat` | Percakapan (buyer/admin) |
| `/dashboard` | Dashboard pembeli |
| `/dashboard/orders` | Riwayat pesanan (filter + search) |
| `/dashboard/orders/{order}` | Detail pesanan + timeline |
| `/dashboard/orders/{order}/confirmation` | Konfirmasi pembayaran |
| `/dashboard/downloads` | Download produk digital |
| `/dashboard/favorit` | Wishlist |
| `/dashboard/profile` | Profil pembeli |
| `/wishlist/toggle/{product}` | AJAX toggle wishlist |
| `/ulasan/{product}` | Submit / edit review |
| `/admin` | Panel admin Filament |

---

## Catatan Teknis

### SQLite Compatibility
- Gunakan `increment()` / `decrement()` daripada `DB::raw()` di `updateOrCreate()` — SQLite tidak support operasi aritmatika dalam `updateOrCreate`.

### N+1 Wishlist Prevention
- `$wishlistIds` di-load via `pluck()` di controller, dikirim ke view, dicek dengan `in_array()` di Blade — hindari query perproduk.

### Filament v5 Custom Page
- Custom `Page` (bukan `ViewRecord`/`EditRecord`) tidak support `$this->form` — gunakan raw `<x-filament::input>` dengan `wire:model` di Blade.

---

## Lisensi

[MIT License](LICENSE) — Hak Cipta &copy; 2026 PublikDigital.
