<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorDashboardController extends Controller
{
    public function index()
    {
        $items = Item::where('user_id', auth()->id())->latest()->get();

        $totalOrders = OrderItem::where('seller_id', auth()->id())->count();

        $earnings = Transaction::where('receiver_id', auth()->id())
            ->where('status', 'completed')
            ->sum('amount');

        return view('vendor.dashboard', compact('items', 'totalOrders', 'earnings'));
    }
}
