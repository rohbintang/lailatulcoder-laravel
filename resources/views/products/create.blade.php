{{-- Form tambah produk --}}
<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="space-y-6">
        {{-- Text input --}}
        <x-forms.input name="name" label="Nama Produk" :required="true"
                        placeholder="Masukkan nama produk..." />

        {{-- Textarea --}}
        <div class="space-y-1">
            <label class="block text-sm font-medium text-gray-700">
                Deskripsi <span class="text-red-500">*</span>
            </label>
            <textarea name="description" rows="4"
                      class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                      placeholder="Deskripsi produk...">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Select --}}
        <div class="space-y-1">
            <label class="block text-sm font-medium text-gray-700">Kategori *</label>
            <select name="category_id"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">-- Pilih Kategori --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                            @selected(old('category_id') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- File upload --}}
        <div class="space-y-1">
            <label class="block text-sm font-medium text-gray-700">Foto Produk</label>
            <input type="file" name="image" accept="image/*"
                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full
                          file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700
                          hover:file:bg-indigo-100">
            @error('image')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2.5 rounded-lg transition">
            Simpan Produk
        </button>
    </div>
</form>
