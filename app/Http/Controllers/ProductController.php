<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use App\Models\Category;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends \App\Http\Controllers\Controller
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

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $data = $request->validate();
        $data['seller_id'] = auth()->id;

        $validated['seller_id'] = auth()->id;
        $validated['is_active'] = true;

        Product::create($data);

        Product::create($validated);

        return redirect()->route('products.index')
        ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('products.create', compact('categories'));
        
    }

    public function edit(Product $product, string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->update($request->validate());

        return redirect()->route('products.show', $product->id)
        ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
    
        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

}