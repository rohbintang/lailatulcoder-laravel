<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\JsonApi\JsonApiResource;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Mime\Message;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('home', function () {
    return response()->json([
        'Message' => 'APi Running'
    ]);
});

Route::apiResource('products', ProductController::class);