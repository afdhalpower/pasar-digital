<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Conversation extends Model
{
    protected $fillable = [
        'buyer_id', 'product_id', 'subject', 'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function lastMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function unreadForAdmin(): int
    {
        return $this->messages()
            ->where('is_read', false)
            ->where('sender_id', '!=', $this->adminId())
            ->count();
    }

    public function unreadForBuyer(): int
    {
        return $this->messages()
            ->where('is_read', false)
            ->where('sender_id', $this->adminId())
            ->count();
    }

    public function scopeForUser($query, User $user)
    {
        if ($user->isAdmin()) {
            return $query;
        }
        return $query->where('buyer_id', $user->id);
    }

    public static function totalUnreadForAdmin(): int
    {
        $adminId = (new static)->adminId();
        return Message::where('is_read', false)
            ->where('sender_id', '!=', $adminId)
            ->count();
    }

    private function adminId(): int
    {
        static $id = null;
        if ($id === null) {
            $id = User::where('email', 'admin@publikdigital.id')->value('id') ?? 1;
        }
        return $id;
    }
}
