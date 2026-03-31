<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function trashed(): View
    {
        $products = Product::onlyTrashed()
            ->with('category', 'seller')
            ->latest('deleted_at')
            ->paginate(20);

        return view('admin.products.trashed', compact('products'));
    }

    public function restore(int $id): RedirectResponse
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.products.trashed')
            ->with('success', "Produk '{$product->name}' berhasil dipulihkan.");
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();

        return redirect()->route('admin.products.trashed')
            ->with('success', "Produk '{$product->name}' dihapus permanen.");
    }
}
