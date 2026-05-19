<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class SitemapController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->get();
        $categories = Category::where('is_active', true)->get();

        return response()->view('sitemap', [
            'products' => $products,
            'categories' => $categories,
        ])->header('Content-Type', 'text/xml');
    }
}
