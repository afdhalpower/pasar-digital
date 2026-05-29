<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use LogsActivity;
    protected $fillable = [
        'order_number',
        'user_id',
        'subtotal',
        'tax',
        'total',
        'discount',
        'unique_code',
        'coupon_id',
        'status',
        'payment_method',
        'payment_status',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'discount' => 'decimal:2',
        'unique_code' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public static function generateOrderNumber(): string
    {
        return 'PD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }

    public static function generateUniqueCode(): int
    {
        do {
            $code = random_int(1, 999);
        } while (static::where('unique_code', $code)
            ->whereIn('payment_status', ['unpaid', 'pending'])
            ->exists()
        );

        return $code;
    }

    public function getTotalTransferAttribute(): float
    {
        return (float) $this->total + ($this->unique_code ?? 0);
    }

    public function getDiscountedSubtotalAttribute(): float
    {
        return (float) $this->subtotal - (float) $this->discount;
    }

    public function getNameForLog(): string
    {
        return $this->order_number;
    }
}
