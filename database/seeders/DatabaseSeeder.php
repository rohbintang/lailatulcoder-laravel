<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat admin dan beberapa seller
        $admin = User::factory()->create([
            'name'     => 'Admin BWA',
            'email'    => 'admin@bwastore.test',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        $sellers = User::factory(5)->create(['role' => 'seller']);

        // 2. Buat kategori
        $categories = collect([
            ['name' => 'Pakaian',      'slug' => 'pakaian',      'icon' => '👕'],
            ['name' => 'Elektronik',   'slug' => 'elektronik',   'icon' => '📱'],
            ['name' => 'Makanan',      'slug' => 'makanan',      'icon' => '🍜'],
            ['name' => 'Olahraga',     'slug' => 'olahraga',     'icon' => '⚽'],
            ['name' => 'Buku',         'slug' => 'buku',         'icon' => '📚'],
            ['name' => 'Kecantikan',   'slug' => 'kecantikan',   'icon' => '💄'],
        ])->each(fn($data) => Category::create($data));

        // 3. Buat produk untuk setiap seller
        $sellers->each(function ($seller) {
            Product::factory(20)->create(['seller_id' => $seller->id]);
            Product::factory(3)->outOfStock()->create(['seller_id' => $seller->id]);
        });

        // 4. Buat 10 produk featured
        Product::factory(10)->featured()->create();

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info("📧 Admin: admin@bwastore.test / password");
    }
}
