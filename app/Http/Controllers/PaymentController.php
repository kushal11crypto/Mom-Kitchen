<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
{
    $query = Payment::with(['order.user', 'order.orderItems.item']);

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