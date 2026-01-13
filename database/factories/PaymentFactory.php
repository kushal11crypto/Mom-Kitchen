<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        $amount = $this->faker->randomFloat(2, 50, 500);

        return [
            'order_id' => Order::factory(),
            'payment_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'amount' => $amount,
            'payment_method' => $this->faker->randomElement(['cash', 'card', 'online']),
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
        ];
    }
}
