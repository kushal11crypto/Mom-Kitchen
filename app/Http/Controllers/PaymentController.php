<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Order;

class PaymentController extends Controller
{
    public function index(Request $request)
{
    $query = Payment::with(['order.user',   'order.orderItems.seller',  'order.orderItems.item']);

    if ($request->filled('date_from')) {
        $query->whereDate('payment_date', '>=', $request->date_from);
    }

    if ($request->filled('date_to')) {
        $query->whereDate('payment_date', '<=', $request->date_to);
    }

    $payments = $query->latest('payment_date')->paginate(15);

    $totalRevenue = Payment::whereIn('payment_status', ['paid', 'success', 'completed'])
        ->sum('payment_amount');

    $totalPending = Payment::where('payment_status', 'pending')
        ->sum('payment_amount');

    return view('admin.payments.index', compact(
        'payments',
        'totalRevenue',
        'totalPending'
    ));
}



// Add this inside the PaymentController class
public function vendorTransactions()
{
    $vendorId = auth()->id();

    // Get orders that have items belonging to this vendor
    $orders = Order::whereHas('orderItems', function ($query) use ($vendorId) {
        $query->where('seller_id', $vendorId);
    })
    ->with(['user', 'orderItems' => function ($query) use ($vendorId) {
        $query->where('seller_id', $vendorId);
    }])
    ->latest()
    ->get();

    // Calculate sum of all earned amounts
    $totalEarnings = $orders->reduce(function ($carry, $order) use ($vendorId) {
        return $carry + $order->orderItems->sum(fn($item) => $item->quantity * $item->unit_price);
    }, 0);

    return view('vendor.transactions', compact('orders', 'totalEarnings'));
}


    public function show(Payment $payment)
    {
        $payment->load('order.user', 'order.orderItems.item');
        return view('admin.payments.show', compact('payment'));
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        $payment->update(['payment_status' => $request->payment_status]);

        return back()->with('success', 'Payment status updated.');
    }
}