<?php

use App\Http\Controllers\dashboarcontroller;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\usercontroller;
use Illuminate\Support\Facades\Route;
use Laravel\Mcp\Enums\Role;

//Basic Routing Laravel
Route::get('/tentang', function () {
    return "<h1>Hello World</h1>";
});

Route::get('/json-test', function () {
    return response()->json([
        'status' => 'Ok',
        'message' => 'APi running',
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [dashboarcontroller::class, 'dashboard'])
        ->name('dashboard');
    Route::get('products', [ProductController::class, 'index'])
        ->name('products.index');
    Route::get('products/{id}', [ProductController::class, 'show'])
        ->name('products.show')
        ->whereNumber('id');
    Route::post('products', [ProductController::class, 'store'])
        ->name('products.store');
    Route::get('profile', [usercontroller::class, 'user'])
        ->name('user.profile');
});

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard']); 
    Route::get('/products', [ProductController::class, 'adminindex']); 
    Route::get('/profile', [UsersController::class, 'user']);
});

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admindashboard'])
            ->name('dashboard');

        Route::get('/products', [ProductsController::class, 'index'])
            ->name('products.index');
    });

require __DIR__.'/admin.php';

Route::resource('products', ProductController::class);