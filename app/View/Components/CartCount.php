<?php

namespace App\View\Components;

use App\Services\CartService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CartCount extends Component
{
    public function __construct(public int $count = 0)
    {
    }

    public function render(): View
    {
        return view('components.cart-count');
    }
}
