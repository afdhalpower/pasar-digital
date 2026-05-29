<?php

namespace App\Helpers;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class RecentlyViewed
{
    private const KEY = 'recently_viewed_products';
    private const MAX = 12;

    public static function add(int $productId): void
    {
        $items = self::getIds();

        $items = array_filter($items, fn ($id) => $id !== $productId);

        array_unshift($items, $productId);

        $items = array_slice($items, 0, self::MAX);

        Session::put(self::KEY, $items);
    }

    public static function getIds(): array
    {
        return Session::get(self::KEY, []);
    }

    public static function get(): array
    {
        $ids = self::getIds();

        if (empty($ids)) {
            return [];
        }

        $products = Product::with('category')
            ->whereIn('id', $ids)
            ->where('is_active', true)
            ->get()
            ->keyBy('id');

        $sorted = [];
        foreach ($ids as $id) {
            if (isset($products[$id])) {
                $sorted[] = $products[$id];
            }
        }

        return $sorted;
    }

    public static function clear(): void
    {
        Session::forget(self::KEY);
    }
}
