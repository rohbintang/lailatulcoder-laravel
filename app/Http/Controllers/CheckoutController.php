<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\Product;
use App\Http\Requests\CheckoutRequest;

class CheckoutController extends Controller
{
    public function store(CheckoutRequest $request): RedirectResponse
    {
        try {
            $order = DB::transaction(function () use ($request) {
                $cartItems = auth()->user()->cartProducts()->with('product')->get();

                if ($cartItems->isEmpty()) {
                    throw new \Exception('Keranjang kosong.');
                }

                $subtotal = $cartItems->sum(fn($p) => $p->price * $p->pivot->quantity);

                $order = Order::create([
                    'user_id'          => auth()->id(),
                    'order_number'     => 'ORD-' . strtoupper(Str::random(8)),
                    'status'           => 'pending',
                    'subtotal'         => $subtotal,
                    'shipping_cost'    => $subtotal >= 100000 ? 0 : 15000,
                    'total_amount'     => $subtotal + ($subtotal >= 100000 ? 0 : 15000),
                    'shipping_address' => $request->shipping_address,
                ]);

                foreach ($cartItems as $cartProduct) {
                    $product = Product::lockForUpdate()->find($cartProduct->id);

                    if ($product->stock < $cartProduct->pivot->quantity) {
                        throw new \Exception("Stok '{$product->name}' tidak mencukupi.");
                    }

                    $order->items()->create([
                        'product_id' => $product->id,
                        'quantity'   => $cartProduct->pivot->quantity,
                        'price'      => $product->price,
                        'subtotal'   => $product->price * $cartProduct->pivot->quantity,
                    ]);

                    $product->decrement('stock', $cartProduct->pivot->quantity);
                }

                // Kosongkan cart
                $request->user()->cartProducts()->detach();

                return $order;
            });

            return redirect()->route('orders.show', $order)
                ->with('success', "Order #{$order->order_number} berhasil dibuat!");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }
};