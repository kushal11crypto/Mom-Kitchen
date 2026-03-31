<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session('cart', []);
        return view('checkout', compact('cart'));
    }

    public function placeOrder(Request $request)
    {
        $cart = session('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Create Order
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_date' => now(),
            'total_amount' => $total,
            'order_status' => 'pending'
        ]);

        // Save Order Items
        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $id,
                'quantity' => $item['quantity']
            ]);
        }

        // Khalti Payment Initiation (Sandbox)
        $response = Http::withHeaders([
            'Authorization' => 'Key b3ac16418d784996bfdcafa351144175', // 🔴 Replace with your Khalti test key
        ])->post('https://a.khalti.com/api/v2/epayment/initiate/', [
            "return_url" => route('payment.verify'),
            "website_url" => url('/'),
            "amount" => $total * 100, // paisa
            "purchase_order_id" => $order->id,
            "purchase_order_name" => "Order #" . $order->id,
        ]);

        $data = $response->json();

        return redirect($data['payment_url']);
    }

    /**
     * Customer Order History
     */
    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('customer.orders', compact('orders'));
    }

    public function verifyPayment(Request $request)
    {
        // Khalti returns pidx
        $pidx = $request->pidx;

        $response = Http::withHeaders([
            'Authorization' => 'Key tb3ac16418d784996bfdcafa351144175',
        ])->post('https://a.khalti.com/api/v2/epayment/lookup/', [
            "pidx" => $pidx
        ]);

        $data = $response->json();

        if ($data['status'] == 'Completed') {

            $order = Order::find($data['purchase_order_id']);
            $order->update(['order_status' => 'paid']);

            session()->forget('cart');

            return redirect('/cart')->with('success', 'Payment successful!');
        }

        return redirect('/cart')->with('error', 'Payment failed!');
    }
}