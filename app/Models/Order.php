<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    protected $fillable = [
        'user_id','order_date','order_status','total_amount'
    ];

    public function updateStatus($newStatus)
{
    // Optional: Add validation for allowed statuses
    $allowedStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
    if (!in_array($newStatus, $allowedStatuses)) {
        throw new \InvalidArgumentException("Invalid status: $newStatus");
    }

    // Update and save
    $this->order_status = $newStatus;
    return $this->save();
}

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
