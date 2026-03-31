<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. High-level Statistics
        $stats = [
            'total_users'    => User::where('role', '!=', 'admin')->count(),
            'total_vendors'  => User::where('role', 'vendor')->count(),
            'total_items'    => Item::count(),
            'total_orders'   => Order::count(),
            'pending_orders' => Order::where('order_status', 'pending')->count(),
            'total_revenue'  => Payment::where('payment_status', 'paid')->sum('payment_amount') ?? 0,
        ];

        // 2. Recent Orders with Relationships
        $recentOrders = Order::with(['customer', 'payment'])
            ->latest()
            ->take(5)
            ->get();

        // 3. Top Items (Ensure 'orderItems' relationship exists in Item model)
        // PostgreSQL requires careful ordering with withCount
        $topItems = Item::with('category')
            ->withCount('orderItems') 
            ->orderBy('order_items_count', 'desc')
            ->take(5)
            ->get();

        // 4. Monthly Revenue (PostgreSQL specific syntax)
        $monthlyRevenue = Payment::where('payment_status', 'paid')
            ->selectRaw('EXTRACT(MONTH FROM payment_date) as month, SUM(payment_amount) as total')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // 5. Order Status Breakdown
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