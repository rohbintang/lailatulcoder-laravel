<div {{ $attributes->merge(['class' => "border px-4 py-3 rounded { $colorClass()}"]) }}>
    <strong class="font-semibold">
        @if ($type === 'success') ✅
        @elseif ($type === 'warning') ⚠️
        @elseif ($type === 'error') ❌
        @else ℹ️
        @endif
    </strong>
    {{ $message ?: $slot }}
</div>