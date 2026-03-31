<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    public function create(): void
    {
        // Cara 1 — new + save
        $product = new Product();
        $product->name = 'Product 1';
        $product->price = 99.99;
        $product->save();
    }
}
