<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        /**
         * ----------------------------
         * 1. BASIC STATS
         * ----------------------------
         */
        $stats = [
            'total_users'    => User::where('role', '!=', 'admin')->count(),
            'total_vendors'  => User::where('role', 'vendor')->count(),
            'total_items'    => Item::count(),
            'total_orders'   => Order::count(),
            'pending_orders' => Order::where('order_status', Order::STATUS_PENDING)->count(),

            

    'pending_orders_amount' => Order::where('order_status', Order::STATUS_PENDING)
    ->with('orderItems')
    ->get()
    ->sum(function ($order) {
        return $order->orderItems->sum(function ($item) {
            return $item->quantity * $item->unit_price;
        });
    }),
            /**
             * FIXED: safer revenue calculation
             * handles multiple payment statuses + numeric casting
             */
            'total_revenue'  => Payment::whereIn('payment_status', [
                    'paid', 'success', 'completed', 'verified'
                ])
                ->selectRaw('COALESCE(SUM(CAST(payment_amount AS DECIMAL(10,2))),0) as total')
                ->value('total'),
        ];

        /**
         * ----------------------------
         * 2. RECENT ORDERS
         * ----------------------------
         */
        $recentOrders = Order::with(['user', 'payment'])
            ->latest()
            ->take(5)
            ->get();

        /**
         * ----------------------------
         * 3. TOP ITEMS
         * ----------------------------
         */
        $topItems = Item::with('category')
            ->withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->take(5)
            ->get();

        /**
         * ----------------------------
         * 4. MONTHLY REVENUE
         * ----------------------------
         */
        $monthlyRevenue = Payment::whereIn('payment_status', [
                'paid', 'success', 'completed', 'verified'
            ])
            ->selectRaw('EXTRACT(MONTH FROM payment_date) as month, SUM(CAST(payment_amount AS DECIMAL(10,2))) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        /**
         * ----------------------------
         * 5. ORDER STATUS BREAKDOWN
         * ----------------------------
         */
        $orderStatusCounts = Order::selectRaw('order_status, COUNT(*) as count')
            ->groupBy('order_status')
            ->pluck('count', 'order_status');

        return view('admin.dashboard.index', compact(
            'stats',
            'recentOrders',
            'topItems',
            'monthlyRevenue',
            'orderStatusCounts'
        ));
    }
}