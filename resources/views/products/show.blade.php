{{-- resources/views/products/show.blade.php --}}
<x-layouts.app :title="$product->name">

    {{-- Push Css --}}
    @push('styles')
        <style>
            .product-gallery {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 8px;
            }
        </style>
    @endpush

    {{-- Konten Halaman --}}
    <div class="product-gallery">
        {{-- Foto Produk --}}
    </div>

    {{-- Push  JS --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                //Logic gallery produk
            });
        </script>
    @endpush

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-gray-700">Home</a>
        <span>/</span>
        <a href="{{ route('products.index') }}" class="hover:text-gray-700">Produk</a>
        <span>/</span>
        <span class="text-gray-900">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- Foto Produk --}}
        <div class="bg-gray-100 rounded-xl aspect-square overflow-hidden">
            @if ($product->image)
                <img src="{{ Storage::url($product->image) }}"
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-300">
                    <span class="text-6xl">📦</span>
                </div>
            @endif
        </div>

        {{-- Info Produk --}}
        <div>
            <x-badge color="blue" class="mb-3">{{ $product->category->name }}</x-badge>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>

            <div class="flex items-baseline gap-3 mb-4">
                <span class="text-3xl font-bold text-indigo-600">
                    @rupiah($product->price)
                </span>
                @if ($product->original_price && $product->original_price > $product->price)
                    <span class="text-lg text-gray-400 line-through">
                        @rupiah($product->original_price)
                    </span>
                @endif
            </div>

            <p class="text-gray-600 leading-relaxed mb-6">{{ $product->description }}</p>

            {{-- Stok --}}
            <div class="flex items-center gap-2 mb-6">
                @if ($product->stock > 0)
                    <x-badge color="green">✓ Stok Tersedia</x-badge>
                    <span class="text-sm text-gray-500">{{ $product->stock }} tersisa</span>
                @else
                    <x-badge color="red">Stok Habis</x-badge>
                @endif
            </div>

            {{-- Tombol Aksi --}}
            @if ($product->stock > 0)
                @auth
                    <form action="{{ route('cart.store') }}" method="POST" class="flex gap-3">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="flex items-center border rounded-lg">
                            <button type="button" class="px-3 py-2 text-gray-600 hover:bg-gray-100">−</button>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                   class="w-12 text-center border-0 focus:ring-0 text-sm">
                            <button type="button" class="px-3 py-2 text-gray-600 hover:bg-gray-100">+</button>
                        </div>
                        <button type="submit"
                                class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-xl transition">
                            🛒 Tambah ke Keranjang
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-xl">
                        Login untuk Beli
                    </a>
                @endauth
            @endif
        </div>
    </div>

</x-layouts.app>
