<?php

namespace App\Filament\Resources\Licenses\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LicenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('order_item_id')
                    ->relationship('orderItem', 'id')
                    ->required(),
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('license_key')
                    ->required(),
                DateTimePicker::make('activated_at'),
                DateTimePicker::make('deactivated_at'),
            ]);
    }
}
