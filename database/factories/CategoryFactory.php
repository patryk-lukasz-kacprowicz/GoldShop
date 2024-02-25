<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'is_visible' => $this->faker->boolean,
            'is_promoted' => $this->faker->boolean,
            'title' => $this->faker->realText(16),
            'description' => $this->faker->realText(2048),
        ];
    }
}
