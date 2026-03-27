{{-- Include di layout --}}
@include('partials.flash')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        <body class="bg-gray-50 antialiased">

    {{-- Navbar --}}
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">
                    BWA Store
                </a>

                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-indigo-600">
                            🛒 Keranjang
                        </a>
                        <a href="{{ route('profile.show') }}" class="text-sm text-gray-700">
                            {{ auth()->user()->name }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-indigo-600">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                           class="text-sm bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 mb-0" role="alert">
            <div class="max-w-7xl mx-auto">{{ session('success') }}</div>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 mb-0" role="alert">
            <div class="max-w-7xl mx-auto">{{ session('error') }}</div>
        </div>
    @endif

    {{-- Konten Halaman --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-800 text-gray-400 mt-16 py-8">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm">
            © {{ date('Y') }} BWA Store. Built with Laravel 12.
        </div>
    </footer>
    </body>
</html>
