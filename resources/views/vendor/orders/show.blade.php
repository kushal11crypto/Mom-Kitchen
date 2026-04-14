<x-app-layout>
<div class="p-4 md:p-8 max-w-5xl mx-auto">
    
    <!-- Top Navigation / Back Button -->
    <div class="mb-6">
        <a href="{{ route('vendor.orders.index') }}" class="inline-flex items-center text-sm font-bold text-orange-600 hover:text-orange-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="15 19l-7-7 7-7"></path></svg>
            Back to Orders
        </a>
    </div>

    <!-- Header Card -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-orange-100 p-6 md:p-8 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="bg-orange-100 text-orange-700 text-xs font-black px-3 py-1 rounded-full uppercase tracking-wider">Order Detail</span>
                <h2 class="text-3xl font-black text-gray-900">#{{ $order->id }}</h2>
            </div>
            <p class="text-gray-500 font-medium">Placed by <span class="text-gray-900 font-bold">{{ $order->user->name }}</span></p>
        </div>
        
        <div class="flex flex-col items-end">
            <span class="mb-2 text-xs font-bold text-gray-400 uppercase tracking-widest">Current Status</span>
            @php
                $statusClasses = [
                    'paid' => 'bg-green-500 text-white shadow-green-200',
                    'pending' => 'bg-yellow-500 text-white shadow-yellow-200',
                ];
                $currentClass = $statusClasses[$order->order_status] ?? 'bg-gray-500 text-white';
            @endphp
            <span class="px-6 py-2 rounded-xl text-sm font-black shadow-lg {{ $currentClass }}">
                {{ strtoupper($order->order_status) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Items Table (Main Content) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/50">
                    <h3 class="font-bold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        Order Items
                    </h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-widest">
                                <th class="px-8 py-4">Dish</th>
                                <th class="px-8 py-4 text-center">Qty</th>
                                <th class="px-8 py-4 text-right">Price</th>
                                <th class="px-8 py-4 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($order->orderItems as $item)
                                @if($item->seller_id == auth()->id())
                                    <tr class="hover:bg-orange-50/20 transition-colors">
                                        <td class="px-8 py-5">
                                            <div class="font-bold text-gray-900">{{ $item->item->item_name ?? 'N/A' }}</div>
                                            <div class="text-xs text-gray-400 font-medium">Standard Portion</div>
                                        </td>
                                        <td class="px-8 py-5 text-center font-bold text-gray-600">
                                            × {{ $item->quantity }}
                                        </td>
                                        <td class="px-8 py-5 text-right text-gray-500">
                                            Rs. {{ number_format($item->unit_price, 2) }}
                                        </td>
                                        <td class="px-8 py-5 text-right font-black text-gray-900">
                                            Rs. {{ number_format($item->quantity * $item->unit_price, 2) }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right: Order Summary Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-gray-900 rounded-[2rem] p-8 text-white sticky top-24 shadow-2xl">
                <h3 class="text-xl font-bold mb-6 border-b border-gray-700 pb-4 text-orange-400">Earnings Summary</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between text-gray-400">
                        <span>Subtotal</span>
                        @php
                            $subtotal = $order->orderItems->where('seller_id', auth()->id())->sum(fn($i) => $i->quantity * $i->unit_price);
                        @endphp
                        <span class="font-bold text-white font-mono">Rs. {{ number_format($subtotal, 2) }}</span>
                    </div>
                    
                    <div class="flex justify-between text-gray-400 border-b border-gray-800 pb-4">
                        <span>Platform Fee (0%)</span>
                        <span class="font-bold text-green-400 font-mono">- Rs. 0.00</span>
                    </div>

                    <div class="flex justify-between items-center pt-2">
                        <span class="text-lg font-bold">Your Pay</span>
                        <span class="text-3xl font-black text-orange-500 font-mono">
                            Rs. {{ number_format($subtotal, 2) }}
                        </span>
                    </div>
                </div>

                <!-- Action Button -->
                <button class="w-full mt-10 bg-orange-600 hover:bg-orange-700 text-white font-black py-4 rounded-2xl transition-all shadow-lg shadow-orange-900/40 active:scale-95">
                    PRINT INVOICE
                </button>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
