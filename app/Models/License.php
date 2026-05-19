<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class License extends Model
{
    protected $fillable = [
        'order_item_id',
        'product_id',
        'user_id',
        'license_key',
        'activated_at',
        'deactivated_at',
    ];

    protected $casts = [
        'activated_at' => 'datetime',
        'deactivated_at' => 'datetime',
    ];

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function generateKey(): string
    {
        do {
            $key = strtoupper(implode('-', [
                Str::random(4),
                Str::random(4),
                Str::random(4),
                Str::random(4),
            ]));
        } while (static::where('license_key', $key)->exists());

        return $key;
    }
}
