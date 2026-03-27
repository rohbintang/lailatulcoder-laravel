<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ title ?? 'Admin' }} | Admin Marketplace</title>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 bg-gray-900 flex-shrink-0 text-white">
            <div class="px-6 py-4 border-gray-900 border-b">
                <span class="font-bold text-lg">⚙️ Admin Panel</span>
            </div>
            <nav class="px-4 py-4 space-y-1">
                <a href="{{ route('admindashboard') }}"
                class="flex items-center px-4 py-4 rounded-lg hover:bg-gray-800 text-sm">
                📊 Dashboard
            </a>
            <a href="{{ route('admin.product.index') }}"
               class="flex items-center px-4 py-4 rounded-lg hover:bg-gray-800 text-sm">
                🛒 Produk
            </a>
            <a href="{{ route('admin.user.index') }}"
               class="flex items-center px-4 py-4 rounded-lg hover:bg-gray-800 text-sm">
                👤 User
            </a>
            </nav>
        </aside>

        {{-- Konten Utama --}}
        <div class="flex overflow-auto">
            <header class="border-b px-6 py-4 bg-white">
                <h2 class="font-semibold text-gray-800">{{ $title ?? 'Dashboard' }}</h2>
            </header>

            <main class="p-6">
                {{ $slot }}
            </main>
        </div>
        
    </div>
</body>
</html>