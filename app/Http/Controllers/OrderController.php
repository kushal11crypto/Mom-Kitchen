<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Transaction;

class OrderController extends Controller
{
    /**
     * Show checkout page
     */
    public function checkout()
    {
        $cart = session('cart', []);
        return view('checkout', compact('cart'));
    }

    /**
     * Place order and initiate Khalti payment
     */
    public function placeOrder(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        // Calculate total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Create Order
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_date' => now(),
            'total_amount' => $total,
            'order_status' => Order::STATUS_PENDING,
        ]);

        // Save Order Items
        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $id,
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'seller_id' => $item['seller_id'],
            ]);
        }

        // Khalti Initiate
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Key b3ac16418d784996bfdcafa351144175',
            ])->post('https://a.khalti.com/api/v2/epayment/initiate/', [
                "return_url" => route('payment.verify'),
                "website_url" => url('/'),
                "amount" => $total * 100,
                "purchase_order_id" => (string) $order->id,
                "purchase_order_name" => "Order #" . $order->id,
            ]);

            $data = $response->json();

            if (isset($data['payment_url'])) {

                // ✅ SAVE pidx
                $order->update([
                    'pidx' => $data['pidx']
                ]);

                return redirect($data['payment_url']);
            }

            return back()->with('error', 'Khalti initiation failed')->with('debug', $data);

        } catch (\Exception $e) {
            Log::error('Khalti initiation error: ' . $e->getMessage());
            return back()->with('error', 'Payment initiation failed.');
        }
    }

    /**
     * Customer Order History
     */
public function myOrders()
{
    $orders = Order::with('orderItems.item')
        ->where('user_id', Auth::id())
        ->latest()
        ->get();

    return view('customer.orders', compact('orders'));
}
public function showOrder($id)
{
    $order = Order::with('orderItems.item', 'orderItems.seller', 'payment')
        ->where('user_id', auth()->id())
        ->findOrFail($id);

    return view('customer.order_details', compact('order'));
}
public function vendorOrders()
{
    $orders = \App\Models\Order::whereHas('orderItems', function ($q) {
        $q->where('seller_id', auth()->id());
    })
    ->with([
        'user',
        'orderItems.item',
        'orderItems.seller'
    ])
    ->latest()
    ->get();

    return view('vendor.orders.index', compact('orders'));
}
public function vendorOrderShow($id)
{
    $order = Order::whereHas('orderItems', function ($q) {
            $q->where('seller_id', auth()->id());
        })
        ->with(['user', 'orderItems.item', 'orderItems.seller'])
        ->findOrFail($id);

    return view('vendor.orders.show', compact('order'));
}
public function vendorTransactions()
{
    $transactions = \App\Models\OrderItem::with('order')
        ->where('seller_id', auth()->id())
        ->whereHas('order', function ($q) {
            $q->where('order_status', 'paid');
        })
        ->latest()
        ->get();

    $totalEarnings = $transactions->sum(function ($item) {
        return $item->quantity * $item->unit_price;
    });

    return view('vendor.transactions.index', compact('transactions', 'totalEarnings'));
}

public function vendorUpdateStatus(Request $request, $id)
{
    $request->validate([
        'order_status' => 'required|in:delivered,cancelled',
    ]);

    $order = \App\Models\Order::findOrFail($id);

    // Verify vendor ownership of items in this order
    $hasItems = $order->orderItems()->where('seller_id', auth()->id())->exists();

    if (!$hasItems) {
        abort(403, 'Unauthorized access to this order.');
    }

    $order->update(['order_status' => $request->order_status]);

    return back()->with('status', 'Order status updated successfully!');
}


    /**
     * Verify Khalti Payment
     */
    public function verifyPayment(Request $request)
    {
        $pidx = $request->pidx;

        if (!$pidx) {
            return redirect('/cart')->with('error', 'Missing pidx.');
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Key b3ac16418d784996bfdcafa351144175',
            ])->post('https://a.khalti.com/api/v2/epayment/lookup/', [
                "pidx" => $pidx
            ]);

            $data = $response->json();

            Log::info('Khalti verify response', $data);

            // ✅ Check success
            if (($data['status'] ?? '') === 'Completed') {

                // ✅ FIND ORDER USING pidx
                $order = Order::where('pidx', $pidx)->first();

                if (!$order) {
                    return redirect('/cart')->with('error', 'Order not found.');
                }

                DB::beginTransaction();

                try {

                    // Prevent duplicate processing
                    if ($order->order_status === 'paid') {
                        DB::commit();
                        return redirect('/cart')->with('success', 'Already paid.');
                    }

                    // ✅ Update order
                    $order->update([
                        'order_status' => 'paid'
                    ]);

                    // Log after update
                    Log::info('Order ID ' . $order->id . ' status after update: ' . $order->fresh()->order_status);

                    // ✅ Save payment
                    $order->payment()->create([
                        'payment_amount' => ($data['total_amount'] ?? 0) / 100,
                        'payment_date' => now(),
                        'payment_status' => 'paid',
                    ]);

                    // ✅ Vendor Transactions
                    foreach ($order->items as $item) {
                        Transaction::create([
                            'sender_id' => $order->user_id,
                            'receiver_id' => $item->seller_id,
                            'amount' => $item->unit_price * $item->quantity,
                            'status' => 'completed',
                            'transaction_date' => now(),
                            'description' => 'Order #' . $order->id,
                        ]);
                    }

                    DB::commit();

                    // Clear cart
                    session()->forget('cart');

                    return redirect('/cart')->with('success', 'Payment successful!');

                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Transaction failed: ' . $e->getMessage());
                    return back()->with('error', 'Transaction failed.');
                }
            }

            return redirect('/cart')->with('error', 'Payment not completed.');

        } catch (\Exception $e) {
            Log::error('Khalti verification error: ' . $e->getMessage());
            return redirect('/cart')->with('error', 'Verification failed.');
        }
    }
}