@props([
    'product',
    'showSeller' => false,
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow hover:shadow-md transition overflow-hidden']) }}>
    <div class="aspect-square bg-gray-100 overflow-hidden">
        @if ($product->image)
            <img src="{{ Storage::url($product->image) }}"
                 alt="{{ $product->name }}"
                 class="w-full h-full object-cover hover:scale-105 transition">
        @else
            <div class="w-full h-full flex items-center justify-center text-gray-300">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        @endif
    </div>

    <div class="p-4">
        @if ($product->category)
            <x-badge color="blue" size="sm" class="mb-2">{{ $product->category->name }}</x-badge>
        @endif

        <h3 class="font-semibold text-gray-800 line-clamp-2">{{ $product->name }}</h3>

        @if ($showSeller)
            <p class="text-xs text-gray-500 mt-1">{{ $product->seller->name }}</p>
        @endif

        <div class="flex items-center justify-between mt-3">
            <span class="text-indigo-600 font-bold">Rp {{ number_format($product->price) }}</span>

            @if ($product->stock > 0)
                <x-badge color="green" size="sm">Tersedia</x-badge>
            @else
                <x-badge color="red" size="sm">Habis</x-badge>
            @endif
        </div>

        <a href="{{ route('products.show', $product) }}"
           class="mt-3 block text-center bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium py-2 rounded-lg transition">
            Lihat Produk
        </a>
    </div>
</div>