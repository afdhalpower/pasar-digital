<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class MarketplaceStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalRevenue = Order::where('payment_status', 'paid')
            ->sum(DB::raw('total + COALESCE(unique_code, 0)'));

        $monthRevenue = Order::where('payment_status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum(DB::raw('total + COALESCE(unique_code, 0)'));

        $pendingRevenue = Order::where('payment_status', 'unpaid')
            ->sum(DB::raw('total + COALESCE(unique_code, 0)'));

        $totalBuyers = User::whereHas('orders', function ($q) {
            $q->where('payment_status', 'paid');
        })->count();

        return [
            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Pendapatan kumulatif')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),

            Stat::make('Pendapatan Bulan Ini', 'Rp ' . number_format($monthRevenue, 0, ',', '.'))
                ->description(now()->format('F Y'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Pendapatan Tertunda', 'Rp ' . number_format($pendingRevenue, 0, ',', '.'))
                ->description('Menunggu pembayaran')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Total Pembeli', $totalBuyers)
                ->description('Pengguna dengan riwayat pembelian')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('Total Produk', Product::where('is_active', true)->count())
                ->description('Produk aktif')
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary'),

            Stat::make('Total Pesanan', Order::count())
                ->description('Semua pesanan')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('warning'),

            Stat::make('Kategori', Category::where('is_active', true)->count())
                ->description('Kategori aktif')
                ->descriptionIcon('heroicon-m-tag')
                ->color('success'),

            Stat::make('Total Download', Product::sum('download_count'))
                ->description('Download produk')
                ->descriptionIcon('heroicon-m-arrow-down-tray')
                ->color('info'),
        ];
    }
}
