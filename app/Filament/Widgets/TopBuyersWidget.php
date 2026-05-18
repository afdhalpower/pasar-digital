<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class TopBuyersWidget extends BaseWidget
{
    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Pembeli Teratas';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::withCount('orders')
                    ->withSum('orders', 'total')
                    ->whereHas('orders')
                    ->orderByDesc('orders_count')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->weight('bold')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('orders_count')
                    ->label('Pesanan')
                    ->counts('orders')
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('orders_sum_total')
                    ->label('Total Belanja')
                    ->money('IDR')
                    ->sortable()
                    ->alignEnd(),
            ])
            ->paginated(false);
    }
}
