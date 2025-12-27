<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = 'Factory Rifle '.fake()->unique()->word();
        return [
            'category_id' => Category::first()?->id ?? Category::factory(),
            'brand_id' => null,
            'name' => $name,
            'slug' => Str::slug($name.'-'.fake()->numberBetween(1,9999)),
            'sku' => 'SKU-'.fake()->numberBetween(1000,9999),
            'price' => fake()->numberBetween(5000,15000),
            'stock' => 5,
            'description' => 'Factory generated item',
        ];
    }
}
