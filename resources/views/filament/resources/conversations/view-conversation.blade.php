@php
    $adminId = \App\Models\User::where('email', 'admin@publikdigital.id')->value('id');
    $messages = $this->messages;
@endphp
<div class="space-y-4">
    {{-- Info --}}
    <div class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl">
        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-teal-500 text-white font-bold text-sm">
            {{ strtoupper(substr($record->buyer->name, 0, 1)) }}
        </div>
        <div>
            <div class="font-semibold text-gray-900 dark:text-gray-100">{{ $record->buyer->name }}</div>
            @if($record->product)
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    {{ __('marketplace.chat_product_label') }} {{ $record->product->name }}
                </div>
            @endif
        </div>
        @if($record->subject)
            <div class="ml-auto text-xs text-gray-400 dark:text-gray-500">{{ $record->subject }}</div>
        @endif
    </div>

    {{-- Messages --}}
    <div class="space-y-3 max-h-[500px] overflow-y-auto p-2" id="messageContainer">
        @forelse($messages as $msg)
            @php $isMine = $msg->sender_id === auth()->id(); @endphp
            <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[75%] rounded-xl px-4 py-2 {{ $isMine ? 'bg-teal-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100' }}">
                    @if($msg->image)
                        <img src="{{ asset('storage/' . $msg->image) }}" alt="{{ __('marketplace.chat_image') }}" class="rounded-lg max-h-48 mb-1">
                    @endif
                    @if($msg->body)
                        <div class="text-sm whitespace-pre-wrap">{{ $msg->body }}</div>
                    @endif
                    <div class="text-xs mt-1 {{ $isMine ? 'text-teal-100' : 'text-gray-400 dark:text-gray-400' }}">
                        {{ $msg->created_at->format('H:i') }}
                        @if(!$isMine && $msg->sender->name !== $record->buyer->name)
                            · {{ $msg->sender->name }}
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-400 dark:text-gray-500">
                {{ __('marketplace.chat_no_messages') }}
            </div>
        @endforelse
    </div>

    {{-- Reply Form --}}
    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
        <form wire:submit="sendReply" class="space-y-3">
            <x-filament::input.wrapper>
                <x-filament::input
                    type="text"
                    wire:model="replyBody"
                    placeholder="{{ __('marketplace.chat_input_placeholder') }}"
                />
            </x-filament::input.wrapper>

            <x-filament::input.wrapper>
                <x-filament::input
                    type="file"
                    wire:model="replyImage"
                    accept="image/*"
                />
            </x-filament::input.wrapper>

            @error('replyBody')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
            @error('replyImage')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror

            <div class="flex justify-end gap-2">
                <x-filament::button type="submit">
                    {{ __('marketplace.chat_send') }}
                </x-filament::button>
            </div>
        </form>
    </div>
</div>

@script
<script>
    const container = document.getElementById('messageContainer');
    if (container) {
        container.scrollTop = container.scrollHeight;
    }
</script>
@endscript
