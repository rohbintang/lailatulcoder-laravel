<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class RecalculateProductRating extends Command
{

    protected $signature = 'marketplace:recalculate-rating
                            {product? : ID produk spesifik (opsional)}
                            {--force : Paksa hitung ulang meski sudah up-to-date}';


    protected $description = 'Hitung ulang rating rata-rata semua produk berdasarkan ulasan';

    public function handle(): int
    {
        $productId = $this->argument('product');

        $products = Product::query()
            ->when($productId, fn($q) => $q->where('id', $productId))
            ->withCount('reviews')
            ->having('reviews_count', '>', 0)
            ->get();

        if ($products->isEmpty()) {
            $this->info('Tidak ada produk yang perlu diupdate.');
            return Command::SUCCESS;
        }

        $bar = $this->output->createProgressBar($products->count());
        $bar->start();

        foreach ($products as $product) {
            $product->update([
                'rating' => $product->reviews()->avg('rating'),
            ]);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("✅ {$products->count()} produk berhasil diupdate.");

        return Command::SUCCESS;
    }
}
