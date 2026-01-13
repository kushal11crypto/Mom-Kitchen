<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $order = Order::create([
            'customer_id' => $request->customer_id,
            'order_date' => now(),
            'order_status' => 'pending',
            'total_amount' => 0
        ]);

        $total = 0;

        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $item['item_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price']
            ]);

            $total += $item['quantity'] * $item['unit_price'];
        }

        $order->update(['total_amount' => $total]);

        return $order->load('items');
    }
}
