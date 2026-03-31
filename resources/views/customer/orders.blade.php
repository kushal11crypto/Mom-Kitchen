<x-app-layout>
    <div class="py-16 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-6">

            <h2 class="text-3xl font-extrabold mb-10">My Orders</h2>

            @forelse($orders as $order)
                <div class="bg-white p-6 rounded-2xl shadow mb-6">

                    <div class="flex justify-between mb-3">
                        <span class="font-bold">Order #{{ $order->id }}</span>
                        <span class="text-sm text-gray-500">
                            {{ $order->created_at->format('M d, Y') }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-600">
                                Total: Rs. {{ $order->total_price }}
                            </p>
                        </div>

                        <span class="px-3 py-1 rounded-full text-sm
                            {{ $order->status == 'completed' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                </div>
            @empty
                <p class="text-gray-500 text-center">No orders yet.</p>
            @endforelse

        </div>
    </div>
</x-app-layout>