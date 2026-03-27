<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
   <x-layouts.app title="Daftar Produk">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Semua Produk</h1>
        @auth
            <a href="{{ route('products.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm font-medium">
                + Tambah Produk
            </a>
        @endauth
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($products as $product)
            <x-product-card :product="$product" :showSeller="true" />
        @empty
            <p class="col-span-4 text-center py-16 text-gray-400">Belum ada produk.</p>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $products->links() }}
    </div>

</x-layouts.app>
</body>
</html>