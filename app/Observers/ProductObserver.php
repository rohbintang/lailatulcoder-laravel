<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductObserver
{
    // Sebelum produk dibuat
    public function creating(Product $product): void
    {
        // Auto-generate slug kalau belum ada
        if (empty($product->slug)) {
            $product->attributes['slug'] = Str::slug($product->name) . '-' . Str::random(6);
        }
    }

    // Setelah produk dibuat
    public function created(Product $product): void
    {
        // Bersihkan cache produk terbaru
        Cache::forget('latest_products');
        Cache::forget("category_{$product->category_id}_products");

        Log::info('New product created', [
            'id'        => $product->id,
            'name'      => $product->name,
            'seller_id' => $product->seller_id,
        ]);
    }

    // Setelah produk diupdate
    public function updated(Product $product): void
    {
        Cache::forget("product_{$product->id}");
        Cache::forget('latest_products');

        // Kalau slug berubah, bisa buat redirect
        if ($product->wasChanged('slug')) {
            // buat redirect dari slug lama ke slug baru
        }
    }

    // Setelah soft delete
    public function deleted(Product $product): void
    {
        Cache::forget("product_{$product->id}");
        Cache::forget('latest_products');
    }

    // Sebelum hard delete — bersihkan file
    public function forceDeleted(Product $product): void
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
    }
}
