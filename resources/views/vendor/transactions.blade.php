<x-app-layout>
    <div class="py-12 bg-[#FFFBF7] min-h-screen">
        <div class="max-w-5xl mx-auto px-4">
            
            <!-- Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gray-900 rounded-[2rem] p-8 text-white shadow-2xl relative overflow-hidden">
                    <p class="text-orange-400 text-[10px] font-black uppercase tracking-widest mb-1">Total Revenue</p>
                    <h3 class="text-3xl font-black">Rs. {{ number_format($totalEarnings, 2) }}</h3>
                    <div class="absolute -right-4 -bottom-4 opacity-10">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.39 2.1-1.39 1.47 0 2.01.59 2.1 1.58h1.39c-.11-1.74-1.21-2.73-2.8-3.01V5h-2v1.65c-1.24.28-2.22 1.06-2.22 2.36 0 1.5 1.22 2.25 3 2.7 1.95.49 2.34 1.2 2.34 1.92 0 .55-.44 1.41-2.15 1.41-1.03 0-2.27-.49-2.42-1.55H7.76c.05 1.79 1.09 2.84 2.72 3.11V19h2v-1.66c1.24-.26 2.22-1.06 2.22-2.36 0-1.77-1.39-2.38-3.32-2.84z""")/>></svg>
                    </div>
                </div>
                <div class="md:col-span-2 bg-white rounded-[2rem] p-8 border border-orange-50 shadow-sm flex items-center">
                    <div>
                        <h2 class="text-2xl font-black text-gray-900">Earnings History</h2>
                        <p class="text-gray-500 text-sm">Detailed record of all payments processed for your kitchen.</p>
                    </div>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="bg-white rounded-[2rem] shadow-[0_10px_40px_rgba(251,146,60,0.1)] border border-orange-50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50/50 border-b border-gray-100">
                            <tr>
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Date</th>
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Order ID</th>
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Earning</th>
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($orders as $order)
                                @php
                                    $orderEarning = $order->orderItems->sum(fn($i) => $i->quantity * $i->unit_price);
                                @endphp
                                <tr class="hover:bg-orange-50/30 transition-colors group">
                                    <td class="px-8 py-5 text-gray-500 font-medium text-sm">
                                        {{ $order->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-8 py-5">
                                        <span class="text-xs font-bold text-orange-600 bg-orange-50 px-3 py-1 rounded-lg">
                                            #{{ $order->id }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 text-right font-black text-gray-900">
                                        Rs. {{ number_format($orderEarning, 2) }}
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase border {{ $order->order_status === 'paid' ? 'bg-green-100 text-green-700 border-green-200' : 'bg-yellow-100 text-yellow-700 border-yellow-200' }}">
                                            {{ $order->order_status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <p class="text-gray-400 font-medium italic">No transactions found yet.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
