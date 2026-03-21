<x-app-layout>
    <div class="min-h-screen bg-slate-50 py-12">
        <div class="max-w-xl mx-auto px-4">
            
            <!-- Header -->
            <div class="mb-8 text-center">
                <h2 class="text-3xl font-extrabold text-gray-900">Finalize Your Order</h2>
                <p class="text-gray-500 mt-2">Please review your items before proceeding to payment.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 overflow-hidden border border-gray-100">
                
                <!-- Order Items Section -->
                <div class="p-8 border-b border-dashed border-gray-200">
                    <h3 class="text-sm uppercase tracking-wider font-bold text-gray-400 mb-6">Order Summary</h3>
                    
                    <div class="space-y-4">
                        @php $total = 0; @endphp
                        @foreach($cart as $item)
                            @php
                                $subtotal = $item['price'] * $item['quantity'];
                                $total += $subtotal;
                            @endphp
                            <div class="flex justify-between items-center text-gray-700">
                                <div class="flex flex-col">
                                    <span class="font-semibold text-gray-900">{{ $item['name'] }}</span>
                                    <span class="text-xs text-gray-400">Qty: {{ $item['quantity'] }} × Rs. {{ number_format($item['price']) }}</span>
                                </div>
                                <span class="font-medium text-gray-900 font-mono">Rs. {{ number_format($subtotal) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Calculation Section -->
                <div class="p-8 bg-gray-50/50">
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-600 text-sm">
                            <span>Subtotal</span>
                            <span class="font-mono">Rs. {{ number_format($total) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600 text-sm">
                            <span>Delivery Fee</span>
                            <span class="text-green-600 font-medium italic">FREE</span>
                        </div>
                        <div class="pt-4 mt-4 border-t border-gray-200 flex justify-between items-center">
                            <span class="text-xl font-bold text-gray-900">Total Amount</span>
                            <span class="text-2xl font-black text-purple-700 font-mono">Rs. {{ number_format($total) }}</span>
                        </div>
                    </div>

                    <!-- Payment Form -->
                    <form action="{{ route('place.order') }}" method="POST" class="mt-8">
                        @csrf
                        <button class="group w-full bg-[#5C2D91] text-white py-4 rounded-2xl font-bold text-lg hover:bg-[#4a2475] transition-all flex items-center justify-center gap-3 shadow-lg shadow-purple-100 transform active:scale-[0.98]">
                            <svg class="w-6 h-6 fill-white" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.82v-1.91c-1.88-.23-3.41-1.34-3.46-3.45h2.15c.05 1.01.7 1.63 1.76 1.63 1.11 0 1.7-.58 1.7-1.42 0-.82-.54-1.28-1.97-1.83-1.63-.61-3.21-1.39-3.21-3.32 0-1.83 1.34-3.08 3.03-3.35V4.5h2.82v1.86c1.68.25 2.96 1.32 3.06 3.1h-2.15c-.08-.94-.65-1.42-1.54-1.42-.92 0-1.57.48-1.57 1.3 0 .76.62 1.13 2.06 1.73 1.73.72 3.12 1.5 3.12 3.42.01 1.95-1.35 3.25-3.24 3.55z"/>
                            </svg>
                            Pay with Khalti
                        </button>
                    </form>
                    
                    <!-- Trust Footer -->
                    <div class="mt-6 flex items-center justify-center gap-2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <span class="text-xs font-medium tracking-tight">Secure SSL Encrypted Payment</span>
                    </div>
                </div>
            </div>

            <!-- Back Link -->
            <div class="mt-6 text-center">
                <a href="{{ route('cart.index') }}" class="text-gray-400 hover:text-gray-600 text-sm font-medium transition-colors">
                   ← Return to Cart
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
