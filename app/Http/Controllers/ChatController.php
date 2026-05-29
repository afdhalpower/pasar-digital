<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $conversations = Conversation::with([
            'buyer',
            'product',
            'lastMessage.sender',
        ])
            ->forUser($user)
            ->orderByDesc('last_message_at')
            ->get();

        return view('chat.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        $user = Auth::user();

        if (!$user->isAdmin() && $conversation->buyer_id !== $user->id) {
            abort(403);
        }

        $conversation->load([
            'buyer',
            'product',
            'messages.sender',
        ]);

        $adminId = $user->isAdmin() ? $user->id : User::where('email', 'admin@publikdigital.id')->value('id');

        $conversation->messages()
            ->where('is_read', false)
            ->where('sender_id', '!=', $user->id)
            ->update(['is_read' => true]);

        return view('chat.show', compact('conversation', 'adminId'));
    }

    public function start(Product $product)
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('chat.index');
        }

        $conversation = Conversation::where('buyer_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'buyer_id' => $user->id,
                'product_id' => $product->id,
                'subject' => 'Tanya tentang ' . $product->name,
            ]);
        }

        return redirect()->route('chat.show', $conversation);
    }

    public function send(Request $request, Conversation $conversation)
    {
        $user = Auth::user();

        if (!$user->isAdmin() && $conversation->buyer_id !== $user->id) {
            abort(403);
        }

        $request->validate([
            'body' => 'nullable|string|max:5000',
            'image' => 'nullable|image|max:2048',
        ]);

        if (!$request->filled('body') && !$request->hasFile('image')) {
            return back()->withErrors(['message' => __('marketplace.chat_required')]);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chat/' . $conversation->id, 'public');
        }

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'body' => $request->body,
            'image' => $imagePath,
        ]);

        $conversation->update(['last_message_at' => now()]);

        return back();
    }
}
