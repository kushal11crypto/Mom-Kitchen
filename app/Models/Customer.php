<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // ✅ fix here
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'consumer_name',
        'email',
        'password',
        'phone_number',
        'address'
    ];

    protected $hidden = ['password'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
