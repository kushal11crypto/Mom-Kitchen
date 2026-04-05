<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',                // User's full name
        'email',               // Email address
        'username',            // Username
        'password',            // Password (hashed)
        'phone_number',        // Phone number
        'address',             // Physical address
        'role',                // Role (e.g., buyer, seller, admin)
        'house_wife_id',       // Optional: related ID if applicable
        'bio',                 // User bio or description
        'balance',             // User's account balance
    ];

    protected $hidden = ['password'];

    /**
     * User's items (products/items they sell)
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /**
     * User's order items where they are the seller
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'seller_id');
    }

    /**
     * Transactions sent by this user
     */
    public function transactionsSent()
    {
        return $this->hasMany(Transaction::class, 'sender_id');
    }

    /**
     * Transactions received by this user
     */
    public function transactionsReceived()
    {
        return $this->hasMany(Transaction::class, 'receiver_id');
    }
}