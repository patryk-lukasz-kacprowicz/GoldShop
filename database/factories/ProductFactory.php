<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'created_by' => User::query()->inRandomOrder()->first()->getKey(),
            'assigned_to' => User::query()->inRandomOrder()->first()->getKey(),
            'is_visible' => $this->faker->boolean,
            'is_available' => $this->faker->boolean,
            'thumbnail' => $this->faker->image,
            'amount' => $this->faker->numberBetween(int1: 1, int2: 100),
            'title' => $this->faker->realText(64),
            'price' => $this->faker->randomFloat(1, 10, 1000),
            'description' => $this->faker->realText(2048),
        ];
    }
}
