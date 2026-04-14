@extends('layouts.admin')

@section('content')
<div class="py-12 bg-[#FFFBF7] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
            <div>
                <h2 class="text-3xl font-black text-gray-900 tracking-tight">Payments Overview</h2>
                <p class="text-gray-500 mt-1">Monitor financial flows across all vendors.</p>
            </div>
            
            <div class="flex gap-4">
                <div class="bg-gray-900 rounded-3xl p-6 text-white shadow-xl min-w-[200px] relative overflow-hidden">
                    <p class="text-orange-400 text-[10px] font-black uppercase tracking-widest mb-1">Total Revenue</p>
                    <h3 class="text-2xl font-black">Rs. {{ number_format($totalRevenue, 2) }}</h3>
                </div>

                <div class="bg-white rounded-3xl p-6 text-gray-900 shadow-sm border border-orange-100 min-w-[200px]">
                    <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Pending</p>
                    <h3 class="text-2xl font-black text-orange-600">Rs. {{ number_format($totalPending, 2) }}</h3>
                </div>
            </div>
        </div>

        <!-- Table Container -->
        <div class="bg-white rounded-[2.5rem] shadow-[0_10px_40px_rgba(0,0,0,0.03)] border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-8 py-6 text-[11px] font-black text-gray-400 uppercase tracking-widest">Transaction</th>
                            <th class="px-8 py-6 text-[11px] font-black text-gray-400 uppercase tracking-widest">Customer</th>
                            <th class="px-8 py-6 text-[11px] font-black text-gray-400 uppercase tracking-widest">Seller Details</th>
                            <th class="px-8 py-6 text-[11px] font-black text-gray-400 uppercase tracking-widest">Amount</th>
                            <th class="px-8 py-6 text-[11px] font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($payments as $payment)
                            <tr class="hover:bg-orange-50/20 transition-colors">
                                <td class="px-8 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold text-orange-600">#{{ $payment->id }}</span>
                                        <span class="text-sm font-black text-gray-900 italic">{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</span>
                                    </div>
                                </td>
                                
                                <td class="px-8 py-5">
                                    <span class="text-sm font-bold text-gray-700">{{ $payment->order->user->name ?? 'N/A' }}</span>
                                </td>

                                <td class="px-8 py-5">
    @foreach($payment->order->orderItems as $orderItem)
        <div class="text-xs">
            <span class="font-bold text-gray-900">{{ $orderItem->item->item_name ?? 'Product' }}</span> 
            <span class="text-gray-400">from</span> 
            <span class="text-orange-600 font-medium">{{ $orderItem->seller->name ?? 'Vendor' }}</span>
        </div>
    @endforeach
</td>


                                <td class="px-8 py-5 text-sm font-black text-gray-900">
                                    Rs. {{ number_format($payment->payment_amount, 2) }}
                                </td>
                                
                                <td class="px-8 py-5 text-center">
                                    @php
                                        $statusStyles = [
                                            'pending' => 'bg-yellow-50 text-yellow-600 border-yellow-100',
                                            'paid'    => 'bg-green-50 text-green-600 border-green-100',
                                            'failed'  => 'bg-red-50 text-red-600 border-red-100',
                                        ];
                                        $currentStyle = $statusStyles[$payment->payment_status] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase border {{ $currentStyle }}">
                                        {{ $payment->payment_status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
