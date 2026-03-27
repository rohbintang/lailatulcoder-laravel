<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $type = 'info',
        public string $message = '',
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
     public function colorClass(): string
    {
        return match($this->type) {
            'success' => 'bg-green-100 border-green-400 text-green-700',
            'warning' => 'bg-yellow-100 border-yellow-400 text-yellow-700',
            'error'   => 'bg-red-100 border-red-400 text-red-700',
            default   => 'bg-blue-100 border-blue-400 text-blue-700',
        };
    }

    public function render(): View
    {
        return view('components.alert');
    }
}
