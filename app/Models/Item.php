<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'user_id','category_id','item_name','price','image_url','availability_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

public function category()
{
    return $this->belongsTo(Category::class, 'category_id', 'id');
}
}
