<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class MarketplaceSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@publikdigital.id'],
            [
                'name' => 'Admin PublikDigital',
                'password' => bcrypt('password'),
            ]
        );

        // 2. Categories
        $categories = [
            ['name' => 'Website Template', 'slug' => 'website-template', 'icon' => 'heroicon-o-globe-alt', 'sort_order' => 1],
            ['name' => 'Mobile App', 'slug' => 'mobile-app', 'icon' => 'heroicon-o-device-phone-mobile', 'sort_order' => 2],
            ['name' => 'UI Kit', 'slug' => 'ui-kit', 'icon' => 'heroicon-o-squares-2x2', 'sort_order' => 3],
            ['name' => 'Grafik & Ilustrasi', 'slug' => 'grafik-ilustrasi', 'icon' => 'heroicon-o-paint-brush', 'sort_order' => 4],
            ['name' => 'Plugin & Script', 'slug' => 'plugin-script', 'icon' => 'heroicon-o-code-bracket', 'sort_order' => 5],
            ['name' => 'E-Book', 'slug' => 'e-book', 'icon' => 'heroicon-o-book-open', 'sort_order' => 6],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], array_merge($cat, ['is_active' => true]));
        }

        // 3. Sample products
        $products = [
            ['name' => 'Starter SaaS Dashboard', 'slug' => 'starter-saas-dashboard', 'category' => 'website-template', 'type' => 'template', 'price' => 350000, 'short_description' => 'Template dashboard SaaS modern dengan dark mode dan 50+ komponen.', 'is_featured' => true],
            ['name' => 'E-Commerce Pro Kit', 'slug' => 'ecommerce-pro-kit', 'category' => 'website-template', 'type' => 'template', 'price' => 500000, 'sale_price' => 399000, 'short_description' => 'Template toko online lengkap dengan cart, checkout, dan payment gateway.', 'is_featured' => true],
            ['name' => 'Flutter Food Delivery', 'slug' => 'flutter-food-delivery', 'category' => 'mobile-app', 'type' => 'template', 'price' => 750000, 'short_description' => 'Source code aplikasi food delivery lengkap dengan driver app dan admin panel.', 'is_featured' => true],
            ['name' => 'Glassmorphism UI Kit', 'slug' => 'glassmorphism-ui-kit', 'category' => 'ui-kit', 'type' => 'asset', 'price' => 199000, 'short_description' => '200+ komponen UI dengan efek glassmorphism untuk Figma & Sketch.', 'is_featured' => true],
            ['name' => 'Invoice Generator Script', 'slug' => 'invoice-generator-script', 'category' => 'plugin-script', 'type' => 'software', 'price' => 150000, 'short_description' => 'Script PHP untuk generate invoice PDF otomatis dengan template kustomisasi.'],
            ['name' => 'Social Media Icon Pack', 'slug' => 'social-media-icon-pack', 'category' => 'grafik-ilustrasi', 'type' => 'asset', 'price' => 99000, 'sale_price' => 49000, 'short_description' => '500+ ikon media sosial dalam format SVG, PNG, dan AI.'],
            ['name' => 'Panduan Laravel Pro', 'slug' => 'panduan-laravel-pro', 'category' => 'e-book', 'type' => 'digital', 'price' => 129000, 'short_description' => 'E-book lengkap belajar Laravel dari dasar hingga production deployment.'],
            ['name' => 'Portfolio Starter Kit', 'slug' => 'portfolio-starter-kit', 'category' => 'website-template', 'type' => 'template', 'price' => 199000, 'short_description' => 'Template portfolio minimalis dengan animasi halus dan dark mode.', 'is_featured' => true],
        ];

        foreach ($products as $p) {
            $category = Category::where('slug', $p['category'])->first();
            Product::firstOrCreate(
                ['slug' => $p['slug']],
                [
                    'name' => $p['name'],
                    'slug' => $p['slug'],
                    'category_id' => $category->id,
                    'user_id' => $admin->id,
                    'type' => $p['type'],
                    'price' => $p['price'],
                    'sale_price' => $p['sale_price'] ?? null,
                    'short_description' => $p['short_description'],
                    'description' => '<p>' . $p['short_description'] . '</p><p>Produk ini dilengkapi dengan dokumentasi lengkap, update gratis, dan support prioritas selama 6 bulan.</p>',
                    'is_active' => true,
                    'is_featured' => $p['is_featured'] ?? false,
                    'view_count' => rand(50, 500),
                    'download_count' => rand(10, 200),
                    'tags' => ['modern', 'premium', 'indonesia', $p['type']],
                    'features' => ['Dokumentasi Lengkap', '6 Bulan Support', 'Update Gratis Selamanya'],
                ]
            );
        }

        // 4. Seed customer users
        $customerNames = [
            'Budi Santoso', 'Siti Aminah', 'Rian Hidayat', 'Dewi Lestari', 
            'Aditya Pratama', 'Putri Utami', 'Fajar Nugroho', 'Rina Wulandari',
            'Hendra Wijaya', 'Sari Indah'
        ];
        
        $customers = [];
        foreach ($customerNames as $name) {
            $email = strtolower(str_replace(' ', '.', $name)) . '@gmail.com';
            $customers[] = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => bcrypt('password'),
                ]
            );
        }

        // 5. Seed orders and order items
        $paymentMethods = ['bank_transfer', 'gopay', 'ovo', 'dana', 'credit_card'];
        $statuses = [
            'completed', 'completed', 'completed', 'completed', 'completed', // 50% completed
            'processing', 'processing', // 20% processing
            'pending', 'pending', // 20% pending
            'cancelled', 'refunded' // 10% other
        ];

        $createdProducts = Product::all();
        
        for ($i = 0; $i < 20; $i++) {
            $customer = $customers[array_rand($customers)];
            $status = $statuses[array_rand($statuses)];
            $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
            
            // Align payment status with order status
            if ($status === 'completed' || $status === 'processing') {
                $paymentStatus = 'paid';
            } elseif ($status === 'pending') {
                $paymentStatus = rand(1, 10) > 7 ? 'failed' : 'unpaid';
            } elseif ($status === 'cancelled') {
                $paymentStatus = 'failed';
            } else {
                $paymentStatus = 'refunded';
            }

            // Create order with random date in last 30 days
            $createdAt = now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
            
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => $customer->id,
                'subtotal' => 0, // Will update after adding items
                'tax' => 0,
                'total' => 0,
                'status' => $status,
                'payment_method' => $paymentMethod,
                'payment_status' => $paymentStatus,
                'notes' => rand(1, 10) > 7 ? 'Mohon diproses cepat, terima kasih.' : null,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            // Add 1 to 3 items per order
            $itemCount = rand(1, 3);
            $selectedProducts = $createdProducts->random($itemCount);
            
            $subtotal = 0;
            foreach ($selectedProducts as $product) {
                $price = $product->effective_price;
                $quantity = 1; // typically 1 for digital products
                $itemTotal = $price * $quantity;
                $subtotal += $itemTotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'price' => $price,
                    'quantity' => $quantity,
                    'total' => $itemTotal,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }

            $tax = round($subtotal * 0.11, 2); // 11% Indonesian VAT (PPN)
            $total = $subtotal + $tax;

            $order->update([
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
            ]);
        }
    }
}

