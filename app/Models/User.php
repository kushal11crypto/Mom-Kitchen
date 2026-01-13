<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable; // Must include HasFactory for factory support

    protected $fillable = [
        'username',
        'password',
        'phone_number',
        'address',
        'house_wife_id',
        'bio'
    ];

    protected $hidden = ['password'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
