<x-app-layout>
<div class="py-12 bg-[#FFFBF7] min-h-screen">
    <div class="p-4 md:p-8 max-w-5xl mx-auto">
        
        <!-- Top Navigation -->
        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('vendor.orders.index') }}" class="inline-flex items-center text-sm font-bold text-orange-600 hover:text-orange-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="15 19l-7-7 7-7"></path></svg>
                Back to Orders
            </a>
            
            @if(session('status'))
                <div class="bg-green-100 text-green-700 px-4 py-1 rounded-full text-xs font-bold animate-pulse">
                    {{ session('status') }}
                </div>
            @endif
        </div>

        <!-- Header Card -->
        <div class="bg-white rounded-[2rem] shadow-sm border border-orange-100 p-6 md:p-8 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="bg-orange-100 text-orange-700 text-xs font-black px-3 py-1 rounded-full uppercase tracking-wider">Order Detail</span>
                    <h2 class="text-3xl font-black text-gray-900">#{{ $order->id }}</h2>
                </div>
                <p class="text-gray-500 font-medium">Customer: <span class="text-gray-900 font-bold">{{ $order->user->name }}</span></p>
            </div>
            
            <div class="flex flex-col items-end">
                <span class="mb-2 text-xs font-bold text-gray-400 uppercase tracking-widest">Global Status</span>
                @php
                    $statusClasses = [
                        'paid' => 'bg-green-500 text-white shadow-green-200',
                        'pending' => 'bg-yellow-500 text-white shadow-yellow-200',
                        'delivered' => 'bg-blue-600 text-white shadow-blue-200',
                        'cancelled' => 'bg-red-500 text-white shadow-red-200',
                    ];
                    $currentClass = $statusClasses[$order->order_status] ?? 'bg-gray-500 text-white';
                @endphp
                <span class="px-6 py-2 rounded-xl text-sm font-black shadow-lg {{ $currentClass }}">
                    {{ strtoupper($order->order_status) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left: Items Table -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/50">
                        <h3 class="font-bold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            My Kitchen Items
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
                                @php $mySubtotal = 0; @endphp
                                @foreach($order->orderItems as $item)
                                    @if($item->seller_id == auth()->id())
                                        @php $mySubtotal += ($item->quantity * $item->unit_price); @endphp
                                        <tr class="hover:bg-orange-50/20 transition-colors">
                                            <td class="px-8 py-5">
                                                <div class="font-bold text-gray-900">{{ $item->item->item_name ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-8 py-5 text-center font-bold text-gray-600">× {{ $item->quantity }}</td>
                                            <td class="px-8 py-5 text-right text-gray-500">Rs. {{ number_format($item->unit_price, 2) }}</td>
                                            <td class="px-8 py-5 text-right font-black text-gray-900">Rs. {{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right: Action Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-gray-900 rounded-[2rem] p-8 text-white sticky top-8 shadow-2xl">
                    <h3 class="text-xl font-bold mb-6 border-b border-gray-700 pb-4 text-orange-400">Order Actions</h3>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between text-gray-400">
                            <span>My Revenue</span>
                            <span class="font-bold text-white font-mono text-lg">Rs. {{ number_format($mySubtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t border-gray-800">
                            <span class="text-sm font-bold uppercase tracking-widest text-gray-500">Payment</span>
                            <span class="text-sm font-black text-green-400">VERIFIED</span>
                        </div>
                    </div>

                    <!-- Action Button: Only show if not already delivered -->
                    @if($order->order_status !== 'delivered' && $order->order_status !== 'cancelled')
                        <form action="{{ route('vendor.orders.updateStatus', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="order_status" value="delivered">
                            
                            <button type="submit" 
                                    onclick="return confirm('Confirm that this order has been delivered?')"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white font-black py-4 rounded-2xl transition-all shadow-lg shadow-green-900/40 active:scale-95 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                MARK AS DELIVERED
                            </button>
                        </form>
                    @else
                        <div class="text-center p-4 bg-gray-800 rounded-2xl border border-gray-700">
                            <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Order Completed</span>
                        </div>
                    @endif

                    <button class="w-full mt-4 bg-slate-700 hover:bg-slate-600 text-white font-bold py-3 rounded-2xl transition-all">
                        PRINT SLIP
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
