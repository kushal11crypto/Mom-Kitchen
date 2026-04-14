@extends('layouts.admin')

@section('content')
<div class="py-12 bg-[#FFFBF7] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
            <div>
                <h2 class="text-3xl font-black text-gray-900 tracking-tight">Marketplace Orders</h2>
                <p class="text-gray-500 mt-1">Full oversight of all customer requests and vendor fulfillments.</p>
            </div>
            
            <!-- Quick Filter -->
            <form action="{{ route('admin.orders.index') }}" method="GET" class="flex gap-2">
                <select name="status" onchange="this.form.submit()" class="rounded-xl border-gray-200 text-sm font-bold focus:ring-orange-500">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                </select>
            </form>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-8 py-6 text-[11px] font-black text-gray-400 uppercase tracking-widest">Order</th>
                            <th class="px-8 py-6 text-[11px] font-black text-gray-400 uppercase tracking-widest">Customer</th>
                            <th class="px-8 py-6 text-[11px] font-black text-gray-400 uppercase tracking-widest">Vendors Involved</th>
                            <th class="px-8 py-6 text-[11px] font-black text-gray-400 uppercase tracking-widest text-right">Total</th>
                            <th class="px-8 py-6 text-[11px] font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                            <th class="px-8 py-6 text-[11px] font-black text-gray-400 uppercase tracking-widest text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($orders as $order)
                            <tr class="hover:bg-orange-50/20 transition-colors group">
                                <td class="px-8 py-5">
                                    <span class="text-xs font-bold text-orange-600">#{{ $order->id }}</span>
                                    <div class="text-[10px] text-gray-400 font-bold uppercase">{{ $order->created_at->format('M d, H:i') }}</div>
                                </td>
                                <td class="px-8 py-5 text-sm font-bold text-gray-700">{{ $order->user->name }}</td>
                                <td class="px-8 py-5">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($order->orderItems->pluck('seller.name')->unique() as $vendor)
                                            <span class="bg-gray-900 text-white text-[9px] font-black px-2 py-1 rounded shadow-sm">
                                                {{ strtoupper($vendor) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-right text-sm font-black text-gray-900">
                                    Rs. {{ number_format($order->total_amount, 2) }}
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase border 
                                        {{ $order->order_status === 'paid' ? 'bg-green-50 text-green-600 border-green-100' : 'bg-yellow-50 text-yellow-600 border-yellow-100' }}">
                                        {{ $order->order_status }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-orange-600 font-black text-xs hover:underline uppercase tracking-widest">Manage</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-6 border-t border-gray-50">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
