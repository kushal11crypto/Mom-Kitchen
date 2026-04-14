@extends('layouts.admin')
@section('title', 'System Overview')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <!-- Total Users -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 uppercase">Total Users</p>
                <h3 class="text-2xl font-bold">{{ $stats['total_users'] }}</h3>
            </div>
            <div class="bg-blue-100 p-3 rounded-full text-blue-600">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 uppercase">Total Revenue</p>
                <h3 class="text-2xl font-bold">
                    Rs.{{ number_format($stats['total_revenue'] ?? 0, 2) }}
                </h3>
            </div>
            <div class="bg-green-100 p-3 rounded-full text-green-600">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
    </div>

    <!-- Pending Orders COUNT -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 uppercase">Pending Orders</p>
                <h3 class="text-2xl font-bold">{{ $stats['pending_orders'] }}</h3>
            </div>
            <div class="bg-yellow-100 p-3 rounded-full text-yellow-600">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>

    <!-- TOTAL ITEMS -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 uppercase">Total Items</p>
                <h3 class="text-2xl font-bold">{{ $stats['total_items'] }}</h3>
            </div>
            <div class="bg-purple-100 p-3 rounded-full text-purple-600">
                <i class="fas fa-utensils"></i>
            </div>
        </div>
    </div>

</div>

<!-- 🔥 NEW ROW: PENDING ORDER AMOUNT -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 uppercase">Pending Orders Amount</p>
                <h3 class="text-2xl font-bold text-yellow-600">
                    Rs.{{ number_format($stats['pending_orders_amount'] ?? 0, 2) }}
                </h3>
            </div>
            <div class="bg-yellow-100 p-3 rounded-full text-yellow-600">
                <i class="fas fa-hourglass-half"></i>
            </div>
        </div>
    </div>

</div>


<!-- RECENT ORDERS + TOP ITEMS -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

    <!-- Recent Orders -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h2 class="text-lg font-bold mb-4">Recent Orders</h2>

        <table class="w-full text-left">
            <thead>
                <tr class="text-gray-400 text-sm border-b">
                    <th class="pb-3">Order ID</th>
                    <th class="pb-3">Customer</th>
                    <th class="pb-3">Amount</th>
                    <th class="pb-3">Status</th>
                </tr>
            </thead>

            <tbody class="text-gray-600 text-sm">
                @foreach($recentOrders as $order)
                <tr class="border-b">

                    <td class="py-3">#{{ $order->id }}</td>

                    <td class="py-3">
                        {{ $order->user->name ?? 'N/A' }}
                    </td>

                    <td class="py-3 font-semibold">
                        Rs.{{ number_format(
    optional($order->payment)->payment_amount
    ?? $order->total_amount
    ?? 0,
2) }}
                    </td>

                    <td class="py-3">
                        <span class="px-2 py-1 rounded-full text-xs
                            {{ $order->order_status == 'pending'
                                ? 'bg-yellow-100 text-yellow-700'
                                : 'bg-green-100 text-green-700' }}">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Top Items -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h2 class="text-lg font-bold mb-4">Top Items</h2>

        <div class="space-y-4">
            @foreach($topItems as $item)
            <div class="flex items-center justify-between border-b pb-2">

                <div class="flex items-center">
                    <img src="{{ $item->image_url ? asset('storage/'.$item->image_url) : 'https://via.placeholder.com/40' }}"
                         class="w-10 h-10 rounded mr-3 object-cover">

                    <div>
                        <p class="font-medium">{{ $item->item_name }}</p>
                        <p class="text-xs text-gray-400">
                            {{ $item->category->categoryName ?? 'Uncategorized' }}
                        </p>
                    </div>
                </div>

                <span class="text-blue-600 font-bold">
                    {{ $item->order_items_count }} Sales
                </span>

            </div>
            @endforeach
        </div>

    </div>

</div>

@endsection