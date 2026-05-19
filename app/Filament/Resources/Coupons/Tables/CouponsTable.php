<?php

namespace App\Filament\Resources\Coupons\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CouponsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Kode')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Kode kupon disalin')
                    ->weight('bold')
                    ->fontFamily('mono'),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state === 'percentage' ? 'Persentase' : 'Nominal')
                    ->color(fn ($state) => $state === 'percentage' ? 'info' : 'warning'),
                TextColumn::make('value')
                    ->label('Nilai')
                    ->formatStateUsing(fn ($state, $record) => $record->type === 'percentage' ? "{$state}%" : "Rp " . number_format($state, 0, ',', '.'))
                    ->sortable(),
                TextColumn::make('min_order_amount')
                    ->label('Min. Pesanan')
                    ->formatStateUsing(fn ($state) => $state ? 'Rp ' . number_format($state, 0, ',', '.') : '-')
                    ->sortable(),
                TextColumn::make('usage')
                    ->label('Pemakaian')
                    ->formatStateUsing(fn ($record) => "{$record->used_count} / " . ($record->max_uses ?: '∞')),
                TextColumn::make('expires_at')
                    ->label('Berlaku Hingga')
                    ->dateTime('d M Y')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
