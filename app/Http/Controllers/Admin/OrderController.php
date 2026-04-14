<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of all marketplace orders.
     */
    public function index(Request $request)
{
    $query = Order::with(['user', 'orderItems.seller', 'orderItems.item']);


    if ($request->filled('status')) {
        $query->where('order_status', $request->status);
    }

    $orders = $query->latest()->paginate(15);

    return view('admin.orders.index', compact('orders'));
}


    /**
     * Display specific order details.
     */
    public function show($id)
{
    $order = Order::with(['user', 'orderItems.seller', 'orderItems.item', 'payment'])
        ->findOrFail($id);

    return view('admin.orders.show', compact('order'));
}


    /**
     * Update order status (Admin Override).
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'order_status' => 'required|string'
        ]);

        $order = Order::findOrFail($id);
        $order->update(['order_status' => $request->order_status]);

        return back()->with('status', 'order-status-updated');
    }
}
