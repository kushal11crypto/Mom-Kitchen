<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_date',
        'order_status',
        'total_amount',
        'pidx', // ✅ IMPORTANT (added)
    ];
      // Cast order_date to Carbon instance
    protected $casts = [
        'order_date' => 'datetime',
    ];

    // ✅ Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Order has many items
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Order has one payment
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Order belongs to user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}