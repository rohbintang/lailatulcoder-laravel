<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $categories = Category::all();
    $products = Product::latest()->paginate(10);

    return view('home', compact('categories', 'products'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('products', ProductController::class)->middleware(['auth', 'product.owner']);

Route::middleware('role:admin')->group(function () {
});

Route::middleware('role:admin,seller')->group(function () {
});

Route::get('/test-product/{id}', function ($id) {
    return App\Models\Product::findOrFail($id);
});

Route::get('/admin', function() {
    return "halaman admin";
})->middleware('role:admin');

require __DIR__.'/auth.php';
