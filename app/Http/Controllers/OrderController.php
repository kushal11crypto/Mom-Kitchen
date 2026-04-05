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

        // Create Order with 'pending' status
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_date' => now(),
            'total_amount' => $total,
            'order_status' => 'pending',
        ]);

        // Save Order Items
        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $id,
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'seller_id' => $item['seller_id'], // ensure this is set in cart
            ]);
        }

        // Initiate Khalti Payment
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Key b3ac16418d784996bfdcafa351144175', // Replace with your Khalti test key
            ])->post('https://a.khalti.com/api/v2/epayment/initiate/', [
                "return_url" => route('payment.verify'),
                "website_url" => url('/'),
                "amount" => $total * 100, // convert to paisa
                "purchase_order_id" => $order->id,
                "purchase_order_name" => "Order #" . $order->id,
            ]);

            $data = $response->json();

            if (isset($data['payment_url'])) {
                return redirect($data['payment_url']);
            }

            return back()->with('error', 'Khalti payment initiation failed.')
                         ->with('debug', $data);

        } catch (\Exception $e) {
            Log::error('Khalti initiation error: '.$e->getMessage());
            return back()->with('error', 'Payment initiation failed, please try again.');
        }
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
        $pidx = $request->pidx;

        if (!$pidx) {
            return redirect('/cart')->with('error', 'Payment verification failed: missing pidx.');
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Key b3ac16418d784996bfdcafa351144175',
            ])->post('https://a.khalti.com/api/v2/epayment/lookup/', [
                "pidx" => $pidx
            ]);

            $data = $response->json();

            Log::info('Khalti verify response', $data);

            if (isset($data['status']) && $data['status'] == 'Completed') {
                $orderId = $data['purchase_order_id'] ?? null;
                $amount  = $data['amount'] ?? 0;

                $order = Order::find($orderId);

                if ($order && $order->order_status != Order::STATUS_PAID) {
                    DB::beginTransaction();

                    try {
                        // Update order status using method
                        $order->updateStatus(Order::STATUS_PAID);

                        // Save payment record
                        $order->payment()->create([
                            'payment_amount' => $amount / 100,
                            'payment_date' => now(),
                            'payment_status' => 'paid',
                        ]);

                        // Process vendor payments and transactions
                        $orderItems = $order->items; // ensure relation exists
                        $vendorAmounts = [];

                        foreach ($orderItems as $item) {
                            $vendorId = $item->seller_id;
                            $vendorAmounts[$vendorId] = ($vendorAmounts[$vendorId] ?? 0) + ($item->unit_price * $item->quantity);
                        }

                        $buyer = $order->user;

                        if (!$buyer) {
                            throw new \Exception('Buyer not found.');
                        }

                        // Check buyer balance
                        $totalAmount = array_sum($vendorAmounts);
                        if ($buyer->balance < $totalAmount) {
                            throw new \Exception('Buyer has insufficient balance.');
                        }

                        // Deduct from buyer
                        $buyer->update([
                            'balance' => $buyer->balance - $totalAmount,
                        ]);

                        // Credit vendors and record transactions
                        foreach ($vendorAmounts as $vendorId => $amountToPay) {
                            $vendor = User::find($vendorId);
                            if (!$vendor) {
                                throw new \Exception('Vendor not found: ID ' . $vendorId);
                            }

                            $vendor->update([
                                'balance' => $vendor->balance + $amountToPay,
                            ]);

                            Transaction::create([
                                'sender_id' => $buyer->id,
                                'receiver_id' => $vendor->id,
                                'amount' => $amountToPay,
                                'status' => 'completed',
                                'transaction_date' => now(),
                                'description' => 'Order payment for Order #' . $order->id,
                            ]);
                        }

                        DB::commit();

                    } catch (\Exception $e) {
                        DB::rollBack();
                        return back()->with('error', 'Transaction failed: ' . $e->getMessage());
                    }
                }

                // Clear cart session
                session()->forget('cart');

                return redirect('/cart')->with('success', 'Payment successful!');
            }

            return redirect('/cart')->with('error', 'Payment failed.');

        } catch (\Exception $e) {
            Log::error('Khalti verification error: ' . $e->getMessage());
            return redirect('/cart')->with('error', 'Payment verification failed.');
        }
    }
}