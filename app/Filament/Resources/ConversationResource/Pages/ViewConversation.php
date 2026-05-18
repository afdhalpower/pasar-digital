<?php

namespace App\Filament\Resources\ConversationResource\Pages;

use App\Filament\Resources\ConversationResource;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Auth;

class ViewConversation extends Page
{
    protected static string $resource = ConversationResource::class;

    protected string $view = 'filament.resources.conversations.view-conversation';

    public Conversation $record;

    public ?string $replyBody = null;

    public ?string $replyImage = null;

    public function mount(Conversation $record): void
    {
        $this->record = $record;

        $adminId = User::where('email', 'admin@publikdigital.id')->value('id');

        $record->messages()
            ->where('is_read', false)
            ->where('sender_id', '!=', $adminId)
            ->update(['is_read' => true]);
    }

    public function getMessagesProperty()
    {
        return $this->record->messages()
            ->with('sender')
            ->orderBy('created_at')
            ->get();
    }

    public function sendReply(): void
    {
        $this->validate([
            'replyBody' => 'nullable|string|max:5000',
            'replyImage' => 'nullable|string',
        ]);

        if (empty($this->replyBody) && empty($this->replyImage)) {
            Notification::make()
                ->warning()
                ->title('Pesan atau gambar harus diisi.')
                ->send();
            return;
        }

        Message::create([
            'conversation_id' => $this->record->id,
            'sender_id' => Auth::id(),
            'body' => $this->replyBody,
            'image' => $this->replyImage,
        ]);

        $this->record->update(['last_message_at' => now()]);

        $this->replyBody = null;
        $this->replyImage = null;

        Notification::make()
            ->success()
            ->title('Pesan terkirim.')
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->url(ConversationResource::getUrl('index'))
                ->icon('heroicon-m-arrow-left'),
            Action::make('delete')
                ->label('Hapus')
                ->color('danger')
                ->icon('heroicon-m-trash')
                ->requiresConfirmation()
                ->action(fn () => $this->record->delete() && redirect(ConversationResource::getUrl('index'))),
        ];
    }

}
