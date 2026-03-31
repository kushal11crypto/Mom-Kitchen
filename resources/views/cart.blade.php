<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">🛒 Your Shopping Cart</h2>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-5xl mx-auto px-6 lg:px-8">
            @php
            $cart = session('cart', []);
            $total = 0;
            @endphp

            @if(count($cart) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Items List -->
                <div class="lg:col-span-8 space-y-6">
                    @foreach($cart as $id => $item)
                    @php
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                    @endphp
                    <div
                        class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-6 hover:shadow-md transition-shadow">
                    
                        <img src="{{ asset('storage/' . $item['image']) }}" 
     class="w-24 h-24 rounded-xl object-cover border border-gray-50"
     alt="{{ $item['name'] }}">



                        <div class="flex-1">
                            <h3 class="font-bold text-lg text-gray-900 leading-tight">{{ $item['name'] }}</h3>
                            <p class="text-sm text-gray-500 mt-1">Rs. {{ number_format($item['price']) }} per unit</p>

                            <div class="flex items-center mt-3 space-x-3">

                                <!-- Decrease -->
                                <form action="{{ route('cart.decrease', $id) }}" method="POST">
                                    @csrf
                                    <button
                                        class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-200 hover:bg-gray-100">
                                        -
                                    </button>
                                </form>

                                <span class="font-semibold text-gray-800">
                                    {{ $item['quantity'] }}
                                </span>

                                <!-- Increase -->
                                <form action="{{ route('cart.increase', $id) }}" method="POST">
                                    @csrf
                                    <button
                                        class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-200 hover:bg-gray-100">
                                        +
                                    </button>
                                </form>

                            </div>
                        </div>

                        <div class="text-right">
                            <p class="text-lg font-bold text-gray-900">Rs. {{ number_format($subtotal) }}</p>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-xs text-red-500 mt-2 hover:underline">
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-4">
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 sticky top-10">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-bottom pb-4">Order Summary</h3>
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="text-xl font-bold text-orange-600">Rs. {{ number_format($total) }}</span>
                        </div>
                        <a href="{{ route('checkout') }}"
                            class="block text-center w-full bg-orange-600 text-white py-4 rounded-xl font-bold text-lg hover:bg-orange-700 transition">
                            Proceed to Checkout
                        </a>
                        <p class="text-center text-xs text-gray-400 mt-4">Taxes and shipping calculated at checkout.</p>
                    </div>
                </div>
            </div>
            @else
            <div class="text-center py-20 bg-white rounded-3xl shadow-sm">
                <div class="text-6xl mb-6">🥡</div>
                <h2 class="text-2xl font-bold text-gray-800">Your cart is feeling lonely.</h2>
                <p class="text-gray-500 mt-2 mb-8">Add some delicious items from our menu to get started!</p>
                <a href="{{ route('customer.menu') }}"
                    class="inline-block bg-orange-600 text-white px-10 py-4 rounded-xl font-bold hover:bg-orange-700 transition">
                    Browse Menu
                </a>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>