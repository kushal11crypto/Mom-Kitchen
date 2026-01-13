<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Customer;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        
    \App\Models\User::factory(5)->create();
    \App\Models\Customer::factory(10)->create();
    \App\Models\Category::factory(5)->create();
    \App\Models\Item::factory(20)->create();
    \App\Models\Order::factory(10)->create()->each(function($order) {
        \App\Models\OrderItem::factory(3)->create(['order_id' => $order->id]);
    });
    \App\Models\Payment::factory(10)->create();
}

    
}
