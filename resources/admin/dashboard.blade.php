<x-layouts.admin title="Recycle Bin Produk">

    <div class="space-y-4">
        @forelse ($products as $product)
            <div class="flex items-center justify-between bg-white rounded-lg p-4 shadow-sm opacity-75">
                <div>
                    <h3 class="font-medium text-gray-700">{{ $product->name }}</h3>
                    <p class="text-xs text-gray-400">
                        Dihapus {{ $product->deleted_at->diffForHumans() }}
                        oleh {{ $product->seller->name }}
                    </p>
                </div>
                <div class="flex gap-2">
                    <form action="{{ route('admin.products.restore', $product->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="text-sm bg-green-100 text-green-700 px-3 py-1 rounded hover:bg-green-200">
                            Pulihkan
                        </button>
                    </form>
                    <form action="{{ route('admin.products.force-delete', $product->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="text-sm bg-red-100 text-red-700 px-3 py-1 rounded hover:bg-red-200">
                            Hapus Permanen
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-400 py-8">Recycle bin kosong.</p>
        @endforelse
    </div>

    {{ $products->links() }}

</x-layouts.admin>