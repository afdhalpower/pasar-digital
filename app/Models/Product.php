<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'sale_price',
        'thumbnail',
        'gallery',
        'file_path',
        'demo_url',
        'type',
        'tags',
        'features',
        'download_count',
        'view_count',
        'rating',
        'review_count',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'gallery' => 'array',
        'tags' => 'array',
        'features' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'rating' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlistedBy(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'wishlists')->withTimestamps();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function getEffectivePriceAttribute(): float
    {
        return $this->sale_price ?? $this->price;
    }

    public function getIsOnSaleAttribute(): bool
    {
        return $this->sale_price !== null && $this->sale_price < $this->price;
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->effective_price, 0, ',', '.');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnail')
            ->singleFile()
            ->registerMediaConversions(function (Media $media = null) {
                $this->registerThumbnailConversions();
            });

        $this->addMediaCollection('gallery');

        $this->addMediaCollection('file')
            ->singleFile();
    }

    protected function registerThumbnailConversions(): void
    {
        $this->addMediaConversion('thumb')
            ->width(320)
            ->height(240)
            ->sharpen(10)
            ->nonQueued();

        $this->addMediaConversion('card')
            ->width(640)
            ->height(480)
            ->sharpen(10)
            ->nonQueued();

        $this->addMediaConversion('large')
            ->width(1200)
            ->height(900)
            ->sharpen(10)
            ->nonQueued();
    }

    public function getThumbnailUrl(): ?string
    {
        if ($media = $this->getFirstMedia('thumbnail')) {
            return $media->getUrl('card');
        }

        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }

        return null;
    }

    public function getFileUrl(): ?string
    {
        if ($media = $this->getFirstMedia('file')) {
            return $media->getUrl();
        }

        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }

        return null;
    }

    // TODO: stock / download limit tracking
    public function getFileDownloadPath(): ?string
    {
        if ($media = $this->getFirstMedia('file')) {
            return $media->getPath();
        }

        if ($this->file_path) {
            return storage_path('app/public/' . $this->file_path);
        }

        return null;
    }
}
