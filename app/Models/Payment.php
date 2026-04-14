<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Payment extends Model
{
    protected $fillable = [
        'order_id','payment_amount','payment_date','payment_status'
    ];
      protected $casts = [
        'payment_amount' => 'decimal:2',
        'payment_date'   => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
