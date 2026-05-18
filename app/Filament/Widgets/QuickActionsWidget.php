<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Route;

class QuickActionsWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Tambah Produk', '')
                ->description('Buat produk baru')
                ->descriptionIcon('heroicon-m-plus', 'before')
                ->color('primary')
                ->url(Route::has('filament.admin.resources.products.create') ? route('filament.admin.resources.products.create') : '#'),
            Stat::make('Lihat Pesanan', '')
                ->description('Kelola pesanan')
                ->descriptionIcon('heroicon-m-shopping-cart', 'before')
                ->color('warning')
                ->url(Route::has('filament.admin.resources.orders.index') ? route('filament.admin.resources.orders.index') : '#'),
            Stat::make('Kelola Kategori', '')
                ->description('Atur kategori produk')
                ->descriptionIcon('heroicon-m-tag', 'before')
                ->color('success')
                ->url(Route::has('filament.admin.resources.categories.index') ? route('filament.admin.resources.categories.index') : '#'),
            Stat::make('Daftar Pengguna', '')
                ->description('Kelola pengguna')
                ->descriptionIcon('heroicon-m-users', 'before')
                ->color('info')
                ->url(Route::has('filament.admin.resources.users.index') ? route('filament.admin.resources.users.index') : '#'),
        ];
    }
}
