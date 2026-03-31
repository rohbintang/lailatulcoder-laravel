<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->words(rand(2, 4), true);
        $price = fake()->numberBetween(15000, 2500000);

        return [
            'name'           => ucwords($name),
            'slug'           => Str::slug($name) . '-' . fake()->unique()->numberBetween(1000, 9999),
            'description'    => fake()->paragraphs(2, true),
            'price'          => $price,
            'original_price' => fake()->boolean(30) ? $price * 1.2 : null,  // 30% punya harga asli
            'stock'          => fake()->numberBetween(0, 200),
            'discount'       => fake()->numberBetween(0, 50),
            'is_active'      => fake()->boolean(85),    // 85% aktif
            'category_id'    => Category::inRandomOrder()->value('id'),
            'seller_id'      => User::inRandomOrder()->value('id'),
        ];
    }

    // State: produk yang sudah habis stok
    public function outOfStock(): static
    {
        return $this->state(['stock' => 0]);
    }

    // State: produk tidak aktif
    public function inactive(): static
    {
        return $this->state(['is_active' => false]);
    }

    // State: produk featured
    public function featured(): static
    {
        return $this->state([
            'is_featured' => true,
            'stock' => fake()->numberBetween(10, 100),
            'is_active' => true,
        ]);
    }
}
