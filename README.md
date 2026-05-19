# PublikDigital — Premium Digital Product Marketplace

**PublikDigital** adalah platform marketplace produk digital premium untuk kreator, developer, dan desainer Indonesia. Dibangun dengan **Laravel 13** + **Filament v5**, mengadaptasi token desain **Google Stitch**.

---

## Fitur Utama

### Marketplace (Frontend)
- **Katalog Produk** — Grid produk digital dengan filter kategori, search, pagination, wishlist indicator
- **Wishlist (Favorit)** — Toggle via AJAX tanpa reload, halaman grid produk terpisah di dashboard
- **Review & Rating** — Bintang 1–5 + komentar oleh pembeli terverifikasi, edit review, aggregate rating otomatis
- **Keranjang Belanja** — Cart berbasis database (tabel `cart_items`), add/update/remove/checkout
- **Kupon Diskon** — Input kode kupon di keranjang, validasi otomatis (expired, max uses, min order), potongan persentase/nominal
- **Checkout & Konfirmasi** — Manual transfer bank + kode unik (1–999) untuk verifikasi admin, diskon kupon otomatis
- **Dashboard Pembeli** — Riwayat pesanan dengan filter & search, detail pesanan (timeline 4-step) + invoice cetak, download produk digital (pagination 12/page), profil
- **Pembatalan Pesanan** — Tombol batalkan di detail pesanan untuk order pending/processing
- **Download Aman** — Signed URL (1 jam expiry) via `URL::temporarySignedRoute`, counter download
- **Lisensi Software** — License key (XXXX-XXXX-XXXX-XXXX) auto-generated saat order selesai, ditampilkan di halaman download
- **Chat In-App** — Tanya jawab buyer-admin tiap produk, dukungan teks + gambar
- **Notifikasi Email** — Order Confirmation, Payment Received, Order Status Changed via Laravel Notifications
- **Toast Global** — Flash message auto-dismiss dengan Alpine.js
- **Lupa Password** — Reset password via email link (Laravel Password Broker)
- **Invoice** — Halaman invoice print-optimized dengan cetak via `window.print()`
- **SEO** — `sitemap.xml` dinamis, `robots.txt`, OG tags (title, description, image), canonical URL, JSON-LD Organization schema
- **Mobile Navigation** — Hamburger toggle, responsive breakpoint, menu khusus mobile
- **Pencarian Global** — Search input di navbar mengarah ke `/katalog?search=`
- **Syarat & Ketentuan** — Halaman statis `/syarat-ketentuan` dengan link di footer
- **Rate Limiting** — Throttle: login (5/menit), register (3/jam), forgot password (3/jam), reset password (5/jam), checkout (5/10 menit), chat (30/menit)

### Admin Panel (Filament v5)
- **Dashboard Stats** — 8 kartu statistik (total revenue, bulan ini, pending, total buyers, produk, kategori, pesanan, download)
- **Grafik Penjualan** — Line chart 30 hari pendapatan
- **Quick Actions** — 4 tombol cepat (Tambah Produk, Pesanan, Kategori, Pengguna)
- **Widget Pesanan** — 5 pesanan terbaru + link edit
- **Widget Pembeli** — Top 5 pembeli (by order count)
- **Manajemen CRUD** — Produk, Kategori, Pesanan, Pengguna
- **Detail Pesanan** — Infolist items + ringkasan keuangan (subtotal, diskon, kode unik, kupon, total transfer)
- **Quick Actions Order** — 5 tombol aksi (Set Lunas, Set Selesai, Proses Pesanan, Batalkan, Hapus) + auto-generate license key
- **Manajemen Kupon** — CRUD kupon diskon (persentase/nominal, min order, max uses, expiry, toggle aktif)
- **Manajemen Lisensi** — View & filter license key per produk/pembeli
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
│   │   ├── Resources/           # Category, Product, Order, User, Conversation, Coupons, Licenses
│   │   └── Widgets/             # StatsOverview, TopProducts, QuickActions, SalesChart, RecentOrders, TopBuyers
│   ├── Http/Controllers/
│   │   ├── Auth/                # Login, Register, ForgotPassword, ResetPassword
│   │   ├── Buyer/               # BuyerDashboardController (orders, downloads, wishlist, reviews, profile)
│   │   ├── HomeController.php
│   │   ├── CatalogController.php
│   │   ├── CartController.php   # + coupon apply/remove
│   │   ├── ChatController.php
│   │   └── SitemapController.php
│   ├── Models/
│   │   ├── Coupon.php           # Kupon diskon dengan isValid() + calculateDiscount()
│   │   └── License.php          # License key dengan generateKey()
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
| `/cart` | Keranjang belanja + kupon |
| `/cart/coupon/apply` | Apply kode kupon (POST) |
| `/cart/coupon/remove` | Hapus kupon (POST) |
| `/chat` | Percakapan (buyer/admin) |
| `/dashboard` | Dashboard pembeli |
| `/dashboard/orders` | Riwayat pesanan (filter + search) |
| `/dashboard/orders/{order}` | Detail pesanan + timeline + invoice |
| `/dashboard/orders/{order}/confirmation` | Konfirmasi pembayaran |
| `/dashboard/orders/{order}/cancel` | Batalkan pesanan (POST) |
| `/dashboard/orders/{order}/invoice` | Invoice print-optimized |
| `/dashboard/downloads` | Download produk digital + license key |
| `/dashboard/favorit` | Wishlist |
| `/dashboard/profile` | Profil pembeli |
| `/lupa-password` | Lupa password |
| `/reset-password/{token}` | Reset password |
| `/syarat-ketentuan` | Syarat & ketentuan |
| `/sitemap.xml` | Sitemap SEO |
| `/robots.txt` | Robots SEO |
| `/wishlist/toggle/{product}` | AJAX toggle wishlist |
| `/ulasan/{product}` | Submit / edit review |
| `/admin` | Panel admin Filament |
| `/admin/coupons` | Manajemen kupon admin |
| `/admin/licenses` | Manajemen lisensi admin |

---

## Catatan Teknis

### SQLite Compatibility
- Gunakan `increment()` / `decrement()` daripada `DB::raw()` di `updateOrCreate()` — SQLite tidak support operasi aritmatika dalam `updateOrCreate`.

### N+1 Wishlist Prevention
- `$wishlistIds` di-load via `pluck()` di controller, dikirim ke view, dicek dengan `in_array()` di Blade — hindari query perproduk.

### Filament v5 Custom Page
- Custom `Page` (bukan `ViewRecord`/`EditRecord`) tidak support `$this->form` — gunakan raw `<x-filament::input>` dengan `wire:model` di Blade.

### Coupon/Discount Flow
- Kupon di-simpan di session (`applied_coupon`) saat user apply di cart, diverifikasi ulang saat checkout.
- `Coupon::isValid()` mengecek: `is_active`, `expires_at`, `max_uses` vs `used_count`.
- `Coupon::calculateDiscount()` support tipe `percentage` (persen dari subtotal) dan `fixed` (nominal tetap, min dari nilai atau subtotal).
- Diskon disimpan di kolom `orders.discount` dan `orders.coupon_id` untuk histori.

### License Auto-Generation
- License key (format `XXXX-XXXX-XXXX-XXXX`) digenerate saat admin klik "Set Selesai" di Filament Order.
- Hanya untuk produk dengan `type = 'software'`.
- Key dicek keunikan via `do-while` loop di `License::generateKey()`.
- License ditampilkan di halaman download buyer, bisa di-copy ke clipboard.

---

## Lisensi

[MIT License](LICENSE) — Hak Cipta &copy; 2026 PublikDigital.
