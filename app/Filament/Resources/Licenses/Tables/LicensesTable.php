<?php

namespace App\Filament\Resources\Licenses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LicensesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('license_key')
                    ->label('License Key')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('License key copied')
                    ->weight('bold')
                    ->fontFamily('mono'),
                TextColumn::make('product.name')
                    ->label('Produk')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Pembeli')
                    ->searchable(),
                TextColumn::make('orderItem.order.order_number')
                    ->label('Order')
                    ->searchable(),
                TextColumn::make('activated_at')
                    ->label('Diaktivasi')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->placeholder('Belum'),
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
