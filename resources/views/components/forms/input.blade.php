@prop([
    'label' => '',
    'name',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
])

<div class="space-y-1">
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
</div>

<input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        placeholder="{{ $placeholder }}"
        value="{{ old($name) }}"
        {{ $attributes->merge(['class' => 'w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500']) }}
        @if ($required) required @endif
    >

    @error($name)
        <p class="text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>

{{-- Panggil dengan dot notation --}}
<x-forms.input
    name="name"
    label="Nama Produk"
    placeholder="Masukkan nama produk..."
    :required="true"
/>

<x-forms.input
    name="price"
    type="number"
    label="Harga"
    placeholder="0"
    :required="true"
/>
