<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Bundle extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'bundle_product')
            ->withPivot('sort_order')
            ->orderByPivot('sort_order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function totalOriginalPrice(): float
    {
        return (float) $this->products->sum('price');
    }

    public function discountPercentage(): int
    {
        $total = $this->totalOriginalPrice();
        if ($total <= 0) {
            return 0;
        }
        return (int) round((1 - ((float) $this->price / $total)) * 100);
    }
}
