<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Category;

class dashboarcontroller extends Controller
{
    public function dashboard(): View
    {
        $lastestproducts = Product::active()
        ->instock()
        ->with('category')
        ->withAvg('reviews', 'rating')
        ->withCount('reviews')
        ->latest()
        ->take(8)
        ->get();

        $featuredproducts = Product::active()
        ->featured()
        ->inStock()
        ->with('category')
        ->take(4)
        ->get();

        $categories = Category::withCount(['products' => fn($q) => $q->active()->inStock()])
        ->having('products_count', '>', 0)
        ->orderBydesc('products_count')
        ->take(6)
        ->get();

        return view('dashboard', compact('lastestproducts', 'featuredproducts', 'categories'));
    }
}
