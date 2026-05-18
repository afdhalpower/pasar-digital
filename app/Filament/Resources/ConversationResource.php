<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConversationResource\Pages;
use App\Models\Conversation;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ConversationResource extends Resource
{
    protected static ?string $model = Conversation::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    protected static ?string $navigationLabel = 'Percakapan';

    protected static ?string $modelLabel = 'Percakapan';

    protected static ?string $pluralModelLabel = 'Percakapan';

    protected static ?int $navigationSort = 5;

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                Conversation::with(['buyer', 'product', 'lastMessage'])
                    ->orderByDesc('last_message_at')
            )
            ->columns([
                Tables\Columns\TextColumn::make('buyer.name')
                    ->label('Pembeli')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Produk')
                    ->limit(20)
                    ->searchable(),
                Tables\Columns\TextColumn::make('lastMessage.body')
                    ->label('Pesan Terakhir')
                    ->limit(40)
                    ->html(false),
                Tables\Columns\TextColumn::make('messages_count')
                    ->label('Pesan')
                    ->counts('messages')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dimulai')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_message_at')
                    ->label('Aktivitas')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                \Filament\Actions\ViewAction::make()
                    ->url(fn (Conversation $record): string => Pages\ViewConversation::getUrl([$record->id])),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('last_message_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConversations::route('/'),
            'view' => Pages\ViewConversation::route('/{record}'),
            'create' => Pages\CreateConversation::route('/create'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $count = Conversation::totalUnreadForAdmin();
        return $count > 0 ? (string) $count : null;
    }
}
