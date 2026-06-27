<?php

namespace Database\Factories;

use App\Models\User;
use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),

            'status' => fake()->randomElement([
                OrderStatus::Pending->value,
                OrderStatus::Confirmed->value,
                OrderStatus::Cancelled->value,
            ]),

            'total' => fake()->randomFloat(
                2,
                100,
                10000
            ),
        ];
    }

    public function confirmed()
    {
        return $this->state([
            'status' => OrderStatus::Confirmed->value
        ]);
    }

    public function pending()
    {
        return $this->state([
            'status' => OrderStatus::Pending->value
        ]);
    }

    public function cancelled()
    {
        return $this->state([
            'status' => OrderStatus::Cancelled->value
        ]);
    }
}
