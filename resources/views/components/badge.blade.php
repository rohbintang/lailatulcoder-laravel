@props([
    'color' => 'gray', //deafult
    'size' => 'md',
]);

@php
    $colorClass = match($color) {
        'green' => 'bg-green-100, text-green-700',
        'red' => 'bg-red-100, text-red-700',
        'yellow' => 'bg-yellow-100, text-yellow-700',
        'blue' => 'bg-blue-100, text-blue-700',
        'default' => 'bg-gray-100, text-gray-700',
    };

    $sizeClass = match($size) {
        'sm' => 'text-xs px-2 py-0.5',
        'lg' => 'text-base px-3 py-1.5',
        default => 'text-xs px-2.5 py-1',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full font-medium $colorClass $sizeClass"]) }}>
    {{ $slot }}
</span>