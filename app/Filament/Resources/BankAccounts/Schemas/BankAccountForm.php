<?php

namespace App\Filament\Resources\BankAccounts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BankAccountForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('bank_name')
                    ->label('Nama Bank')
                    ->required()
                    ->maxLength(100),
                TextInput::make('account_number')
                    ->label('No. Rekening')
                    ->required()
                    ->maxLength(50),
                TextInput::make('account_holder')
                    ->label('Atas Nama')
                    ->required()
                    ->maxLength(255),
                TextInput::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->inline(false)
                    ->default(true),
            ]);
    }
}
