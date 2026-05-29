<?php

namespace App\Http\Controllers;

use App\Helpers\RecentlyViewed;
use App\Models\Bundle;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('is_active', true);

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $sort = $request->get('sort', 'latest');
        $query = match ($sort) {
            'price_low' => $query->orderBy('price', 'asc'),
            'price_high' => $query->orderBy('price', 'desc'),
            'popular' => $query->orderBy('download_count', 'desc'),
            default => $query->latest(),
        };

        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        $wishlistIds = Auth::check() ? Auth::user()->wishlistProducts()->pluck('product_id')->toArray() : [];

        return view('catalog.index', compact('products', 'categories', 'wishlistIds'));
    }

    public function bundles()
    {
        $bundles = Bundle::with('products')
            ->active()
            ->latest()
            ->paginate(12);

        return view('bundles.index', compact('bundles'));
    }

    public function show(string $slug)
    {
        $product = Product::with(['category', 'user'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $product->increment('view_count');

        RecentlyViewed::add($product->id);

        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        $wishlistIds = Auth::check() ? Auth::user()->wishlistProducts()->pluck('product_id')->toArray() : [];

        $ogImage = $product->getThumbnailUrl();

        $recentlyViewed = \App\Helpers\RecentlyViewed::get();

        return view('catalog.show', compact('product', 'relatedProducts', 'wishlistIds', 'ogImage', 'recentlyViewed'));
    }
}
