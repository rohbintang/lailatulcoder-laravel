<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::latest()->paginate(12);

        return view('products.index', compact('products'));
    }

    public function show($id): View
    {
        $product = Product::findOrFail($id);

        return view('products.show', compact('product'));
    }
}