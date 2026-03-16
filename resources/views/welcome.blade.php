<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mom's Kitchen | Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-orange-50 font-sans antialiased">

    <!-- Navigation Bar -->
    <nav class="flex justify-between items-center p-6 bg-white shadow-sm sticky top-0 z-50">
        <h1 class="text-2xl font-extrabold text-orange-600 tracking-tight">Mom's Kitchen</h1>
        
        <div class="space-x-6 flex items-center">
            <a href="#how-it-works" class="hidden md:block text-gray-600 hover:text-orange-600 font-medium">How it Works</a>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-orange-600 font-semibold">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-orange-600 font-semibold">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-orange-600 text-white px-5 py-2.5 rounded-full font-bold hover:bg-orange-700 transition-all shadow-md">Get Started</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <!-- Main Hero Section -->
    <main class="max-w-6xl mx-auto px-6 py-16">
        <div class="grid md:grid-cols-2 gap-12 items-center bg-white p-8 md:p-16 rounded-[3rem] shadow-xl border border-orange-100">
            <div>
                <span class="text-orange-600 font-bold uppercase tracking-widest text-sm">Community Powered Food</span>
                <h2 class="text-5xl md:text-6xl font-black text-gray-900 mt-4 mb-6 leading-tight">
                    Eat Fresh. <br><span class="text-orange-600">Sell Dashboardmade.</span>
                </h2>
                <p class="text-lg text-gray-600 mb-10">
                    Connect with local home chefs for authentic meals, or turn your own kitchen into a thriving business.
                </p>
                
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('register') }}?role=customer" class="bg-orange-600 text-white px-8 py-4 rounded-2xl text-lg font-bold shadow-lg hover:bg-orange-700 hover:-translate-y-1 transition-all">
                        Order Food
                    </a>
                    <a href="{{ route('register') }}?role=vendor" class="bg-orange-100 text-orange-700 px-8 py-4 rounded-2xl text-lg font-bold hover:bg-orange-200 transition-all">
                        Become a Seller
                    </a>
                </div>
            </div>
            <div class="hidden md:block relative">
                <!-- Replace with an actual image of food or a home chef -->
                <div class="w-full h-80 bg-orange-200 rounded-3xl overflow-hidden shadow-inner flex items-center justify-center">
                    <span class="text-orange-400 font-bold">Chef Image / Illustration</span>
                </div>
            </div>
        </div>

        <!-- Vendor Promotion Section -->
        <section class="mt-20 py-12 border-t border-orange-100">
            <div class="text-center mb-12">
                <h3 class="text-3xl font-bold text-gray-800">Why Join Mom's Kitchen?</h3>
            </div>
            <div class="grid md:grid-cols-2 gap-8">
                <!-- For Customers -->
                <div class="bg-orange-100/50 p-8 rounded-3xl border border-orange-200">
                    <h4 class="text-2xl font-bold text-orange-800 mb-4">For Customers</h4>
                    <ul class="text-orange-900 space-y-3">
                        <li class="flex items-center">✓ Healthy, preservative-free meals</li>
                        <li class="flex items-center">✓ Support local home-based sellers</li>
                        <li class="flex items-center">✓ Authentic regional recipes</li>
                    </ul>
                </div>
                <!-- For Sellers -->
                <div class="bg-gray-900 p-8 rounded-3xl text-white">
                    <h4 class="text-2xl font-bold text-orange-400 mb-4">For Vendors</h4>
                    <ul class="text-gray-300 space-y-3">
                        <li class="flex items-center">✓ Start your business from home</li>
                        <li class="flex items-center">✓ Set your own menu and prices</li>
                        <li class="flex items-center">✓ Reach thousands of hungry locals</li>
                    </ul>
                </div>
            </div>
        </section>
    </main>

    <!-- Simple Footer -->
    <footer class="text-center py-10 text-gray-400 text-sm">
        &copy; {{ date('Y') }} Mom's Kitchen. All rights reserved.
    </footer>

</body>
</html>