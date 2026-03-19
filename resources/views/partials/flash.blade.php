{{-- resources/views/partials/flash.blade.php --}}
@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
         class="fixed top-4 right-4 z-50 flex items-center gap-3 bg-white border-l-4 border-green-500
                shadow-lg rounded-lg px-4 py-3 max-w-sm">
        <span class="text-green-500">✅</span>
        <p class="text-sm text-gray-700">{{ session('success') }}</p>
        <button @click="show = false" class="ml-auto text-gray-400 hover:text-gray-600">✕</button>
    </div>
@endif

@if (session('error'))
    <div class="fixed top-4 right-4 z-50 flex items-center gap-3 bg-white border-l-4 border-red-500
                shadow-lg rounded-lg px-4 py-3 max-w-sm">
        <span class="text-red-500">❌</span>
        <p class="text-sm text-gray-700">{{ session('error') }}</p>
    </div>
@endif
