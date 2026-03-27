<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

Route::prefix('admin')->name('admin')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])
        ->name('admindashboard');
});

Route::prefix('admin-product')->name('admin-product.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])
        ->name('dashboard');
});

Route::prefix('admin-user')->name('admin-user.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])
        ->name('dashboard');
});