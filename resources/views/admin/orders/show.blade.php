@extends('layouts.admin')

@section('content')
<div class="py-12 bg-[#FFFBF7] min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back Button -->
        <div class="mb-8">
            <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-sm font-bold text-orange-600 hover:text-orange-700 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Back to Orders
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- LEFT: Order Details & Items -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Main Info Card -->
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-orange-50 p-8">
                    <div class="flex justify-between items-start mb-8">
                        <div>
                            <span class="bg-orange-100 text-orange-700 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest">Global Order</span>
                            <h2 class="text-4xl font-black text-gray-900 mt-2">#{{ $order->id }}</h2>
                            <p class="text-gray-400 mt-1">Placed on {{ $order->created_at->format('M d, Y \a\t H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">Customer</label>
                            <p class="text-lg font-black text-gray-900">{{ $order->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-50 pt-8">
                        <h3 class="text-lg font-black text-gray-900 mb-6">Order Items</h3>
                        <div class="space-y-4">
                            @foreach($order->orderItems as $item)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm border border-gray-100">
                                            <i class="fas fa-utensils text-orange-500"></i>
                                        </div>
                                        <div>
                                            <p class="font-black text-gray-900">{{ $item->item->item_name ?? 'Deleted Item' }}</p>
                                            <p class="text-xs text-gray-400 font-bold uppercase tracking-tighter">Seller: {{ $item->seller->name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-gray-900">{{ $item->quantity }} x Rs. {{ number_format($item->unit_price, 2) }}</p>
                                        <p class="text-md font-black text-orange-600">Rs. {{ number_format($item->quantity * $item->unit_price, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Management Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Status Update Card -->
                <div class="bg-gray-900 rounded-[2.5rem] p-8 text-white shadow-2xl sticky top-8">
                    <h3 class="text-xl font-black text-orange-500 mb-6 flex items-center">
                        <i class="fas fa-cog mr-2"></i> Manage Order
                    </h3>

                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')
                        
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-2">Change Status</label>
                            <select name="order_status" class="w-full bg-slate-800 border-slate-700 text-white rounded-xl py-3 px-4 font-bold focus:ring-orange-500">
                                <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ $order->order_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-black py-4 rounded-2xl transition-all shadow-lg shadow-orange-900/40">
                            UPDATE STATUS
                        </button>
                    </form>

                    <div class="mt-10 pt-8 border-t border-slate-800">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 font-bold uppercase text-[10px] tracking-widest">Total Value</span>
                            <span class="text-2xl font-black text-orange-500 font-mono">Rs. {{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Status Card -->
                <div class="bg-white rounded-[2rem] p-8 border border-orange-50 shadow-sm">
                    <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Payment Tracking</h4>
                    @if($order->payment)
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full {{ $order->payment->payment_status == 'paid' ? 'bg-green-500' : 'bg-yellow-500' }}"></div>
                            <p class="font-bold text-gray-700">Payment {{ ucfirst($order->payment->payment_status) }}</p>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1">Transaction ID: {{ $order->payment->id }}</p>
                    @else
                        <p class="text-gray-400 italic text-sm">No payment record found.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
