<?php

namespace App\Http\Middleware;

use App\Models\Product;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureProductOwner
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $product = Product::findOrFail($request->route('product'));

        if ($product->seller_id !== Auth::user()?->id) {
            abort(403, 'Kamu tidak punya akses ke produk ini.');
        }

        return $next($request);
    }
}