<x-app-layout>
    <div class="py-16 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-6">

            <h2 class="text-3xl font-extrabold mb-10">My Orders</h2>

            @forelse($orders as $order)
                <div class="bg-white p-6 rounded-2xl shadow mb-6">
                    <div class="flex justify-between mb-3">
                        <a href="{{ route('customer.orders.show', $order->id) }}" class="font-bold text-lg hover:underline">
                            Order #{{ $order->id }}
                        </a>
                        <span class="text-sm text-gray-500">
                            {{ $order->order_date ? $order->order_date->format('M d, Y') : 'Date not available' }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center mb-4">
                        <p class="text-gray-600 font-medium">
                            Total: Rs. {{ number_format($order->total_amount, 2) }}
                        </p>

                        @php
                            $status = $order->order_status;
                            $badgeClasses = match($status) {
                                'paid' => 'bg-green-100 text-green-600',
                                'processing' => 'bg-blue-100 text-blue-600',
                                'shipped' => 'bg-indigo-100 text-indigo-600',
                                'delivered' => 'bg-purple-100 text-purple-600',
                                'cancelled' => 'bg-red-100 text-red-600',
                                default => 'bg-yellow-100 text-yellow-600',
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-full text-sm {{ $badgeClasses }}">
                            {{ ucfirst($status) }}
                        </span>
                    </div>

                    {{-- Items Preview --}}
                    <div class="border-t pt-3">
                        @foreach($order->orderItems as $item)
                            @php
                                $itemName = $item->item ? $item->item->item_name : 'Item Deleted';
                                $quantity = $item->quantity ?? 1;
                                $totalPrice = ($item->unit_price ?? 0) * $quantity;
                            @endphp
                            <div class="flex justify-between text-gray-700 text-sm mb-2">
                                <span>{{ $itemName }} x {{ $quantity }}</span>
                                <span>Rs. {{ number_format($totalPrice, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center mt-10">You have no orders yet.</p>
            @endforelse

        </div>
    </div>
</x-app-layout>