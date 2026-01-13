<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    // The model this factory is for
    protected $model = User::class;

    public function definition()
    {
        return [
            'username' => $this->faker->userName(),
            'password' => Hash::make('password'), // default password
            'phone_number' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'house_wife_id' => $this->faker->randomNumber(5, true),
            'bio' => $this->faker->sentence(),
        ];
    }
}
