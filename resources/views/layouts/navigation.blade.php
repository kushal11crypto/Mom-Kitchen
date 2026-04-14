<nav class="bg-white shadow-md">
    @php
        $cartCount = count(session('cart', []));
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
            <div class="flex items-center space-x-6">

                @if(auth()->user()->role === 'vendor')

    <!-- Dashboard -->
    <a href="{{ route('vendor.dashboard') }}"
       class="text-gray-700 hover:text-orange-600 font-medium">
        Dashboard
    </a>

    
    <!-- Orders -->
    <a href="{{ route('vendor.orders.index') }}"
       class="text-gray-700 hover:text-orange-600 font-medium">
        Orders
    </a>

    <!-- Earnings / Transactions -->
    <a href="{{ route('vendor.transactions.index') }}"
       class="text-gray-700 hover:text-orange-600 font-medium">
        Earnings
    </a>

    <!-- Profile -->
    <a href="{{ route('profile.edit') }}"
       class="text-gray-700 hover:text-orange-600 font-medium">
        Profile
    </a>

@endif

                <!-- ✅ Customer Links -->
                @if(auth()->user()->role === 'customer')

                    <!-- Menu -->
                    <a href="{{ route('customer.menu') }}"
                       class="{{ request()->routeIs('customer.menu') ? 'text-orange-600 font-bold' : 'text-gray-700' }} hover:text-orange-600">
                        Menu
                    </a>

                    <!-- Orders -->
                    <a href="{{ route('customer.orders') }}"
                       class="{{ request()->routeIs('customer.orders') ? 'text-orange-600 font-bold' : 'text-gray-700' }} hover:text-orange-600">
                        Orders
                    </a>

                    <!-- Profile -->
                    <a href="{{ route('profile.edit') }}"
                       class="{{ request()->routeIs('profile.edit') ? 'text-orange-600 font-bold' : 'text-gray-700' }} hover:text-orange-600">
                        Profile
                    </a>

                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}"
                       class="relative bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition">
                        🛒
                        <span class="hidden sm:inline">Cart</span>

                        <!-- Badge -->
                        <span id="cart-count-badge"
                              class="absolute -top-2 -right-2 bg-white text-orange-600 text-xs px-2 py-1 rounded-full {{ $cartCount > 0 ? '' : 'hidden' }}">
                            {{ $cartCount }}
                        </span>
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