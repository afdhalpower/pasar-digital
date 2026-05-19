<?php

namespace App\Filament\Resources\Coupons\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CouponForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label('Kode Kupon')
                    ->required()
                    ->maxLength(50),
                TextInput::make('name')
                    ->label('Nama Kupon')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
                Select::make('type')
                    ->label('Tipe Diskon')
                    ->options([
                        'percentage' => 'Persentase (%)',
                        'fixed' => 'Nominal (Rp)',
                    ])
                    ->required()
                    ->default('percentage'),
                TextInput::make('value')
                    ->label('Nilai Diskon')
                    ->required()
                    ->numeric()
                    ->suffix(fn ($get) => $get('type') === 'percentage' ? '%' : 'Rp'),
                TextInput::make('min_order_amount')
                    ->label('Min. Pembelian')
                    ->numeric()
                    ->prefix('Rp'),
                TextInput::make('max_uses')
                    ->label('Maks. Penggunaan')
                    ->numeric(),
                TextInput::make('used_count')
                    ->label('Sudah Digunakan')
                    ->required()
                    ->numeric()
                    ->default(0),
                DateTimePicker::make('expires_at')
                    ->label('Berlaku Hingga'),
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->inline(false)
                    ->required(),
            ]);
    }
}
