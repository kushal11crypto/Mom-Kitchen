<nav class="bg-white shadow-md">
    @php
        $cartCount = collect(session('cart', []))->sum('quantity');
    @endphp

    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">

            <!-- 🔷 Logo -->
            <div class="text-xl font-bold text-orange-600">
                <a href="{{ route('dashboard') }}">
                    Mom's Kitchen
                </a>
            </div>

            <!-- 🔷 Right Side -->
            <div class="flex items-center space-x-4">

                <!-- ✅ Vendor Dashboard -->
                @if(auth()->user()->role === 'vendor')
                    <a href="{{ route('vendor.dashboard') }}"
                       class="text-gray-700 hover:text-orange-600 font-medium">
                        Dashboard
                    </a>
                @endif

                <!-- ✅ Customer Cart -->
                @if(auth()->user()->role === 'customer')
                    <a href="{{ route('cart.index') }}"
                       class="relative bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition">

                        🛒 Cart

                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-white text-orange-600 text-xs px-2 py-1 rounded-full">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                @endif

                <!-- 👤 User -->
                <div class="text-gray-700 font-medium">
                    {{ Auth::user()->name }}
                </div>

                <!-- 🚪 Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-red-500 hover:text-red-600 font-medium">
                        Logout
                    </button>
                </form>

            </div>
        </div>
    </div>
</nav>