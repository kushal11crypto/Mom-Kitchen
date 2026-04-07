<x-app-layout>
    <div class="py-16 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-6">

            <h2 class="text-3xl font-extrabold mb-6">Order Details</h2>

            <div class="bg-white p-6 rounded-2xl shadow mb-6">
                {{-- Order Info --}}
                <div class="flex justify-between mb-3">
                    <span class="font-bold text-lg">Order #{{ $order->id }}</span>
                    <span class="text-sm text-gray-500">
                        {{ $order->order_date ? $order->order_date->format('M d, Y H:i') : 'Date not available' }}
                    </span>
                </div>

                <div class="flex justify-between items-center mb-4">
                    <p class="text-gray-700 font-medium">
                        Total Amount: Rs. {{ number_format($order->total_amount, 2) }}
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

                {{-- Payment Info --}}
                <div class="mb-4 border-t pt-3">
                    <h3 class="font-semibold text-gray-700 mb-2">Payment Details</h3>
                    @if($order->payment)
                        <div class="flex justify-between text-gray-700 text-sm">
                            <span>Status:</span>
                            <span class="font-medium">{{ ucfirst($order->payment->payment_status) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-700 text-sm">
                            <span>Amount Paid:</span>
                            <span class="font-medium">Rs. {{ number_format($order->payment->payment_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-700 text-sm">
                            <span>Payment Date:</span>
                            <span class="font-medium">{{ $order->payment->payment_date->format('M d, Y H:i') }}</span>
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">Payment not completed yet.</p>
                    @endif
                </div>

                {{-- Items --}}
                <div class="border-t pt-3">
                    <h3 class="font-semibold text-gray-700 mb-2">Items</h3>
                    <div class="space-y-3">
                        @foreach($order->items as $item)
                            @php
                                $itemName = $item->item ? $item->item->name : 'Item Deleted';
                                $unitPrice = $item->unit_price ?? 0;
                                $quantity = $item->quantity ?? 1;
                                $totalPrice = $unitPrice * $quantity;
                            @endphp
                            <div class="flex justify-between items-center text-gray-700 text-sm p-2 rounded-lg bg-gray-50">
                                <div>
                                    <span class="font-medium">{{ $itemName }}</span>
                                    <span class="text-gray-500">x {{ $quantity }}</span>
                                    @if($item->item)
                                        <span class="text-gray-400 text-xs">(Rs. {{ number_format($unitPrice, 2) }} each)</span>
                                    @endif
                                    <div class="text-gray-500 text-xs mt-1">
                                        Vendor: {{ $item->seller ? $item->seller->name : 'Unknown' }}
                                    </div>
                                </div>
                                <span class="font-medium">Rs. {{ number_format($totalPrice, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Back button --}}
                <a href="{{ route('customer.orders') }}" class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    &larr; Back to Orders
                </a>

            </div>
        </div>
    </div>
</x-app-layout>