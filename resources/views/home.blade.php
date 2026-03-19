<x-app-layout title="Selamat Datang">

    <div class="flex flex-col gap-8 md:flex-row">
        {{-- Sidebar Filter --}}
        <aside class="w-full md:w-64 shrink-0">
            <div class="flex container bg-white rounded-xl shadow-sm p-5">
                <h3 class="text-semibold px-3 mb-4 mt-4 text-gray-800">Filter</h3>

                <form action="{{ route('products.index') }}" method="GET">
                    <div class="mb-5">
                        <label class="block text-sm font-medium p-5 text-gray-800 ">Kategori</label>
                        <div class="space-y-2">
                            @foreach ($categories as $category)
                                <label class="text-sm text-gray-800 flex items-center gap-2">
                                    <input type="radio" name="category" value="{{ $category->slug }}"
                                        @checked(request('category') === $category->slug) class="text-indigo-600 focus:ring-indigo-500">
                                    {{ $category->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
        
    

            {{-- Filter Harga --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-800 gap-4">Harga</label>
                <div class="flex gap-2">
                    <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}"
                    class="w-full md:w-64 rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}"
                    class="w-full md:w-64 rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>
        
            <button type="submmit" class="rounded-lg w-full bg-indigo-600 hover:bg-indigo-700 text-sm font-medium py-2">Terapkan Filter</button>
        
            @if (request()->hasAny(['category', 'min_price', 'max_price', 'q']))
                <a href="{{ route('products.index') }}"
                 class="block text-center text-xs font-medium py-4 text-gray-500 hover:text-gray-700 mt-2">
                 Reset Filter
                </a>
            @endif
        </aside>
        
        {{-- Grid Produk --}}
        <div class="flex-xl">
            <div class="flex items-center gap-4 mb-6">
                <form method="GET" action="{{ route('products.index') }}" class="flex-1" gap-2>
                    <input placeholder="Cari Produk..." type="text" name="q" value="{{ request('q') }}" class="flex-1 rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="submit" class="bg-indigo-600 rounded-lg hover:bg-indigo-700 text-sm p-5 text-white py-2 px-4">Cari</button>
                </form>

                <select name="sort" form="sort-form" class="rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="latest" @selected(request('sort', 'latest') === 'latest')>Terbaru</option>
                    <option value="price_low" @selected(request('sort') === 'price_low')>Harga Terendah</option>
                    <option value="price_high" @selected(request('sort') === 'price_high')>Harga Tertinggi</option>
                </select>
                <form id="sort-form" method="GET" action="{{ route('products.index') }}" class="hidden">
                    @foreach (request()->except('sort') as $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                </form>
            </div>
            {{-- Produk Grid --}}
            <div class="grid grid-cols-2 lg:grid-cold-3 xl:grid-cols-4 gap-4">
                @forelse ($products as $product)
                    <x-product-card :product="$product" />
                @empty
                    <div class="col-span-4 text-center py-16">
                        <p class="text-gray-400 text-lg">Produk Ditemukan</p>
                        <a href="{{ route('products.index') }}" class="text-indigo-600 text-sm mt-2 inline-block">
                            Lihat semua produk
                        </a>
                    </div>
                @endforelse
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @forelse ($products as $product)
                    <x-product-card :product="$product" />
                @empty
                    <div class="col-span-4 text-center py-16">
                        <p class="text-lg text-gray-400">Produk tidak ditemukan</p>
                    </div>
                @endforelse
            </div>
            {{-- Render pagination links --}}
            <div class="mt-8">
                {{ $products->links() }}
            </div>
            {{-- Pagination --}}
            <div class="mt-8 flex container items-center justify-between">
                <p class="text-sm text-gray-500">
                    {{ $products->total() }} Produk ditemukan
                </p>
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </div>

    <section class="text-white px-8 py-16 mb-11 bg-gradient-to-tr from-indigo-600 to-purple-800">
        <div class="max-w-2x1">
            <h1 class="font-bold text-4xl mb-5">
                Belanja mudah dengan dirumah
            </h1>
            <p class="text-indigo-100 text-lg mb-7">
                Temukan jutaan produk berkualitas dengan harga terjangkau
            </p>
            <a href="{{ route('products.index') }}" class="font-semibold inline-block bg-white text-indigo-600 mb-8 px-6 py-5 rounded-xl hover:bg-indigo-50 transition">
                Belanja Sekarang
            </a>
        </div>
    </section>

    {{-- Produk Terbaru --}}
    <section class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-300">
                Produk Terbaru
            </h2>
            <a href= "{{ route('products.index') }}" class="text-sm text-indigo-600 hover:underline">
                Lihat Semua
            </a>
        </div>
    </section>
    
    {{-- Kategori --}}
    <section class="text-xl font-semibold text-white mb-6">Kategori Populer
        <div class="container grid grid-cols-3 md:grid-cols-6 gap-4">
            @foreach ($categories as $category)
                <a href="{{ route('products.index', ['category=> $category->slug']) }}"
                class="bg-white rounded-xl items-center flex hover:shadow-md transition mt-4 gap-2 p-4 flex-col text-center group">
                <span class="text-3xl">{{ $category->icon ?? '📦' }}</span>
                <span class="text-xs font-medium text-gray-700 group-hover:text-indigo-600">
                    {{ $category->name }}
                </span>
                </a>
            @endforeach
        </div>
    </section>
</x-app-layout>
