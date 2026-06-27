<?php

namespace Database\Factories;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = fake()->numberBetween(100,5000);
        $quantity = fake()->numberBetween(1,5);

        return [
            'product_name'  => fake()->word(),
            'quantity'      => $quantity,
            'price'         => $price,
            'total'         => $price * $quantity,
        ];
    }
}
