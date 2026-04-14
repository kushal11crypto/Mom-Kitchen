<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', "Mom's Kitchen") }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://bunny.net" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-[#FFFBF7]">
        <div class="min-h-screen flex flex-col items-center pt-12 sm:pt-20">
            
            <!-- Branding Header -->
            <div class="mb-8 text-center">
                <a href="/" class="flex flex-row items-center gap-4 group">
                    <div class="bg-white p-4 rounded-3xl group-hover:scale-105 transition-transform duration-300">
                        <!-- Using your actual logo path -->
                        <img src="{{ asset('storage/uploads/logo.png') }}" alt="Logo" class="h-20 w-24 w-auto object-contain">
                    </div>
                    <h1 class="text-3xl font-black text-gray-900 tracking-tight">
                        Mom's <span class="text-orange-600">Kitchen</span>
                    </h1>
                </a>
            </div>

            <!-- Form Card -->
            <div class="w-full sm:max-w-md px-8 py-10 bg-white shadow-[0_20px_50px_rgba(251,146,60,0.08)] border border-orange-50 overflow-hidden sm:rounded-[2.5rem]">
                {{ $slot }}
            </div>

            <!-- Simple Footer -->
            <footer class="mt-8 text-gray-400 text-xs font-medium uppercase tracking-widest">
                &copy; {{ date('Y') }} Authentic Home Flavours
            </footer>
        </div>
    </body>
</html>
