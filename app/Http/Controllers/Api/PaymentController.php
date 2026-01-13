<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        return Payment::create([
            'order_id' => $request->order_id,
            'payment_amount' => $request->payment_amount,
            'payment_date' => now(),
            'payment_status' => 'paid'
        ]);
    }
}
