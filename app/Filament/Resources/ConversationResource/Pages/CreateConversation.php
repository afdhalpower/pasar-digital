<?php

namespace App\Filament\Resources\ConversationResource\Pages;

use App\Filament\Resources\ConversationResource;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Product;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateConversation extends CreateRecord
{
    protected static string $resource = ConversationResource::class;

    public function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->components([
                Select::make('buyer_id')
                    ->label('Pembeli')
                    ->options(User::where('email', '!=', 'admin@publikdigital.id')->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Select::make('product_id')
                    ->label('Produk (opsional)')
                    ->options(Product::where('is_active', true)->pluck('name', 'id'))
                    ->searchable()
                    ->nullable(),
                TextInput::make('subject')
                    ->label('Judul (opsional)')
                    ->maxLength(255),
                Textarea::make('first_message')
                    ->label('Pesan Pertama')
                    ->required()
                    ->maxLength(5000),
                FileUpload::make('first_image')
                    ->label('Gambar (opsional)')
                    ->image()
                    ->maxSize(2048)
                    ->disk('public')
                    ->directory('chat/new'),
            ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return [
            'buyer_id' => $data['buyer_id'],
            'product_id' => $data['product_id'] ?? null,
            'subject' => $data['subject'] ?? 'Percakapan dari Admin',
            'last_message_at' => now(),
        ];
    }

    protected function afterCreate(): void
    {
        $data = $this->data;

        Message::create([
            'conversation_id' => $this->record->id,
            'sender_id' => Auth::id(),
            'body' => $data['first_message'] ?? '',
            'image' => $data['first_image'] ?? null,
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return ConversationResource::getUrl('view', [$this->record]);
    }
}
