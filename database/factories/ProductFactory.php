<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'description' => fake()->paragraphs(3, true),
            'short_description' => fake()->sentence(),
            'price' => fake()->randomFloat(0, 10000, 500000),
            'type' => fake()->randomElement(['digital', 'template', 'software', 'asset']),
            'is_active' => true,
            'is_featured' => false,
            'download_count' => 0,
            'view_count' => 0,
            'rating' => 0,
            'review_count' => 0,
        ];
    }
}
