<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'category_id' => Category::factory(), // automatically create a category
            'user_id' => User::factory(), // automatically create a user
        ];
    }
}
