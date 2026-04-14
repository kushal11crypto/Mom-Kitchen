<x-app-layout>
<div class="p-8 max-w-7xl mx-auto">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Order History</h2>
            <p class="text-gray-500 mt-1">Manage your incoming requests and track your earnings.</p>
        </div>
        <div class="bg-orange-100 px-4 py-2 rounded-2xl border border-orange-200">
            <span class="text-orange-800 font-semibold">Total Orders: {{ $orders->count() }}</span>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white border border-gray-100 shadow-xl rounded-[2rem] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider">Order ID</th>
                        <th class="px-6 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider">My Earnings</th>
                        <th class="px-6 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                        @php
                            $vendorTotal = $order->orderItems
                                ->where('seller_id', auth()->id())
                                ->sum(fn($item) => $item->quantity * $item->unit_price);
                        @endphp

                        <tr class="hover:bg-orange-50/30 transition-colors group">
                            <td class="px-6 py-4">
                                <span class="text-sm font-mono font-bold text-orange-600 bg-orange-50 px-2 py-1 rounded-lg">
                                    #{{ $order->id }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-9 w-9 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold text-xs mr-3">
                                        {{ substr($order->user->name, 0, 1) }}
                                    </div>
                                    <span class="font-medium text-gray-900">{{ $order->user->name }}</span>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <span class="text-lg font-black text-gray-900">
                                    <span class="text-sm font-normal text-gray-400">Rs.</span> {{ number_format($vendorTotal, 2) }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'paid' => 'bg-green-100 text-green-700 border-green-200',
                                        'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                        'cancelled' => 'bg-red-100 text-red-700 border-red-200'
                                    ];
                                    $currentClass = $statusClasses[$order->order_status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $currentClass }}">
                                    {{ strtoupper($order->order_status) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('vendor.orders.show', $order->id) }}"
                                   class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl shadow-sm hover:bg-orange-600 hover:text-white hover:border-orange-600 transition-all duration-200">
                                    Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="bg-gray-50 p-4 rounded-full mb-4">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    </div>
                                    <p class="text-gray-400 font-medium">No orders yet. Keep cooking!</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-app-layout>
