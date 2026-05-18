@extends('layouts.marketplace')

@section('title', $conversation->subject ?? 'Percakapan - PublikDigital')

@push('styles')
<style>
.chat-thread {
    display: flex;
    flex-direction: column;
    height: calc(100vh - 240px);
    min-height: 400px;
}
.chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: var(--space-3) 0;
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.chat-date-separator {
    text-align: center;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--color-outline);
    padding: var(--space-2) 0;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.chat-bubble {
    max-width: 75%;
    padding: 12px 16px;
    border-radius: var(--radius-lg);
    line-height: 1.5;
    word-wrap: break-word;
    position: relative;
}
.chat-bubble--mine {
    align-self: flex-end;
    background: var(--color-primary-container);
    color: var(--color-on-primary-container);
    border-bottom-right-radius: 4px;
}
.chat-bubble--theirs {
    align-self: flex-start;
    background: var(--color-surface-container-high);
    color: var(--color-on-surface);
    border-bottom-left-radius: 4px;
}
.chat-bubble-image {
    max-width: 100%;
    max-height: 300px;
    border-radius: var(--radius-md);
    display: block;
    margin-bottom: 4px;
}
.chat-bubble-time {
    font-size: 0.65rem;
    opacity: 0.6;
    margin-top: 4px;
    text-align: right;
}
.chat-input-container {
    border-top: 1px solid var(--color-outline-variant);
    padding: var(--space-2) 0;
    background: var(--color-surface);
}
.chat-input-form {
    display: flex;
    gap: 8px;
    align-items: flex-end;
}
.chat-input-field {
    flex: 1;
    resize: none;
}
.chat-file-label {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    border-radius: var(--radius-md);
    background: var(--color-surface-container-high);
    border: 1px solid var(--color-outline-variant);
    cursor: pointer;
    transition: all 0.2s;
    flex-shrink: 0;
    color: var(--color-on-surface-variant);
}
.chat-file-label:hover {
    border-color: var(--color-primary);
    color: var(--color-primary);
}
.chat-file-label input {
    display: none;
}
.chat-send-btn {
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--radius-md);
    background: var(--color-primary);
    color: var(--color-on-primary);
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    flex-shrink: 0;
}
.chat-send-btn:hover {
    background: var(--color-primary-container);
    color: var(--color-on-primary-container);
}
.chat-image-preview {
    display: none;
    padding: 8px 0;
}
.chat-image-preview img {
    max-height: 80px;
    border-radius: var(--radius-sm);
}
.chat-info {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    margin-bottom: var(--space-3);
    padding-bottom: var(--space-2);
    border-bottom: 1px solid var(--color-outline-variant);
}
.chat-info-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--color-primary);
    color: var(--color-on-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1rem;
    flex-shrink: 0;
}
</style>
@endpush

@section('content')
<section class="section" style="padding-top:100px;">
    <div class="container">
        <div style="margin-bottom:var(--space-2);">
            <a href="{{ route('chat.index') }}" style="color:var(--color-primary); text-decoration:none; font-size:0.875rem;">
                &larr; Kembali
            </a>
        </div>

        <div class="chat-info">
            <div class="chat-info-avatar">{{ strtoupper(substr($conversation->buyer->name, 0, 1)) }}</div>
            <div>
                <div style="font-weight:600;">{{ $conversation->buyer->name }}</div>
                @if($conversation->product)
                    <div style="font-size:0.8rem; color:var(--color-on-surface-variant);">
                        Produk: {{ $conversation->product->name }}
                    </div>
                @endif
            </div>
        </div>

        <div class="chat-thread">
            <div class="chat-messages" id="chatMessages">
                @php
                    $lastDate = null;
                @endphp
                @forelse($conversation->messages as $msg)
                    @php
                        $msgDate = $msg->created_at->format('Y-m-d');
                    @endphp
                    @if($msgDate !== $lastDate)
                        <div class="chat-date-separator">
                            {{ $msg->created_at->isToday() ? 'Hari Ini' : ($msg->created_at->isYesterday() ? 'Kemarin' : $msg->created_at->translatedFormat('d F Y')) }}
                        </div>
                        @php $lastDate = $msgDate; @endphp
                    @endif
                    <div class="chat-bubble {{ $msg->is_mine ? 'chat-bubble--mine' : 'chat-bubble--theirs' }}">
                        @if($msg->image)
                            <img src="{{ asset('storage/' . $msg->image) }}" alt="Gambar" class="chat-bubble-image" loading="lazy">
                        @endif
                        @if($msg->body)
                            <div>{{ nl2br(e($msg->body)) }}</div>
                        @endif
                        <div class="chat-bubble-time">{{ $msg->created_at->format('H:i') }}</div>
                    </div>
                @empty
                    <div style="text-align:center; padding:var(--space-6); color:var(--color-on-surface-variant);">
                        Belum ada pesan. Kirim pesan pertama!
                    </div>
                @endforelse
            </div>

            <div class="chat-input-container">
                <form method="POST" action="{{ route('chat.send', $conversation) }}" enctype="multipart/form-data" class="chat-input-form" id="chatForm">
                    @csrf
                    <label class="chat-file-label" title="Lampirkan gambar">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                        <input type="file" name="image" accept="image/*" id="chatImage">
                    </label>
                    <div class="chat-image-preview" id="imagePreview">
                        <img src="" alt="Preview">
                        <button type="button" id="removeImage" style="background:none; border:none; color:var(--color-error); cursor:pointer; font-size:0.75rem;">Hapus</button>
                    </div>
                    <textarea name="body" class="input-field chat-input-field" rows="1" placeholder="Tulis pesan..." id="chatInput" style="padding:10px 16px;"></textarea>
                    <button type="submit" class="chat-send-btn" title="Kirim">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"/>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                        </svg>
                    </button>
                </form>
                @error('message')
                    <div style="color:var(--color-error); font-size:0.8rem; margin-top:4px;">{{ $message }}</div>
                @enderror
                @error('image')
                    <div style="color:var(--color-error); font-size:0.8rem; margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// Auto-resize textarea
const input = document.getElementById('chatInput');
if (input) {
    input.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });
}

// Scroll to bottom
const messages = document.getElementById('chatMessages');
if (messages) {
    messages.scrollTop = messages.scrollHeight;
}

// Image preview
const fileInput = document.getElementById('chatImage');
const preview = document.getElementById('imagePreview');
const previewImg = preview.querySelector('img');
const removeBtn = document.getElementById('removeImage');

if (fileInput) {
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
}

if (removeBtn) {
    removeBtn.addEventListener('click', function() {
        fileInput.value = '';
        preview.style.display = 'none';
        previewImg.src = '';
    });
}
</script>
@endpush
