<div class="bg-white rounded-lg shadow overflow-hidden">
    @if ($title)
        <div class="px-6 py-4 borber-b bg-gray-50">
            <h3 class="font-semibold text-gray-800">{{ $title }}</h3>
        </div>
    @endif

    <div class="px-6 py-4">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="px-6 py-3 bg-gray-50 border-t text-sm text-gray-500">
            {{ $footer }}
        </div>
    @endisset
</div>
