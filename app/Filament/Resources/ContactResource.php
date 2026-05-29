<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationLabel = 'Kontak Masuk';

    protected static ?string $modelLabel = 'Kontak';

    protected static ?string $pluralModelLabel = 'Pesan Masuk';

    protected static ?int $navigationSort = 6;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('subject')
                    ->label('Subjek')
                    ->searchable()
                    ->limit(40),
                TextColumn::make('message')
                    ->label('Pesan')
                    ->limit(60)
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_read')
                    ->label('Dibaca')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-envelope')
                    ->trueColor('success')
                    ->falseColor('warning'),
                TextColumn::make('created_at')
                    ->label('Diterima')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                TernaryFilter::make('is_read')
                    ->label('Status')
                    ->placeholder('Semua')
                    ->trueLabel('Sudah dibaca')
                    ->falseLabel('Belum dibaca'),
            ])
            ->actions([
                Action::make('mark_read')
                    ->label('Tandai Dibaca')
                    ->icon('heroicon-m-check')
                    ->color('success')
                    ->action(fn (Contact $record) => $record->update(['is_read' => true]))
                    ->visible(fn (Contact $record) => !$record->is_read),
                ViewAction::make()
                    ->form([
                        Components\TextInput::make('name')->disabled(),
                        Components\TextInput::make('email')->disabled(),
                        Components\TextInput::make('subject')->disabled(),
                        Components\Textarea::make('message')->disabled()->rows(8),
                    ])
                    ->after(fn (Contact $record) => $record->update(['is_read' => true])),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('mark_read_bulk')
                        ->label('Tandai Dibaca')
                        ->icon('heroicon-m-check')
                        ->action(fn ($records) => $records->each->update(['is_read' => true])),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) Contact::unread()->count();
    }
}
