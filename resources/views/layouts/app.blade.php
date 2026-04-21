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
    </head>
    <body class="font-sans antialiased flex flex-col min-h-screen">

    <div class="flex-1 bg-gray-100">
        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="flex-1">
            {{ $slot }}
        </main>
    </div>
        <!-- 🔻 Footer -->
<footer class="bg-white border-t mt-10">
    <div class="max-w-7xl mx-auto px-6 py-10">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Brand -->
            <div>
                <h2 class="text-xl font-bold text-orange-600">Mom's Kitchen</h2>
                <p class="text-gray-600 mt-3 text-sm">
                    Fresh, homemade meals delivered with love. Enjoy delicious food anytime!
                </p>
            </div>

            <!-- Links -->
            <div>
                <h3 class="font-semibold text-gray-800 mb-3">Quick Links</h3>
                <ul class="space-y-2 text-gray-600 text-sm">
                    <li><a href="{{ route('dashboard') }}" class="hover:text-orange-600">Dashboard</a></li>
                    <li><a href="{{ route('customer.menu') }}" class="hover:text-orange-600">Menu</a></li>
                    <li><a href="{{ route('customer.orders') }}" class="hover:text-orange-600">Orders</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="font-semibold text-gray-800 mb-3">Contact</h3>
                <p class="text-gray-600 text-sm">Email: support@momskitchen.com</p>
                <p class="text-gray-600 text-sm mt-1">Phone: +977-9800000000</p>
            </div>

        </div>

        <!-- Bottom -->
        <div class="border-t mt-8 pt-4 text-center text-sm text-gray-500">
            © {{ date('Y') }} Mom's Kitchen. All rights reserved.
        </div>

    </div>
</footer>
    </body>
</html>
