<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'customer_id' => Customer::factory(),
            'order_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'order_status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
            'total_amount' => 0, // will update later after creating OrderItems
        ];
    }
}
