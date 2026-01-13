<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition()
    {
        $quantity = $this->faker->numberBetween(1, 5);
        $unitPrice = $this->faker->randomFloat(2, 10, 100);

        return [
            'order_id' => Order::factory(),
            'item_id' => Item::factory(),
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
        ];
    }
}
