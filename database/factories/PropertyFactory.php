<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Roofy API: Factory for seeding property listings.
 * Fixed documents to array (matches JSON cast) and status values.
 */
class PropertyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'status' => fake()->randomElement(['sell', 'rent']),
            'availability' => fake()->boolean(80),
            'description' => fake()->paragraph(),
            'totalArea' => fake()->numberBetween(50, 500),
            'floor' => fake()->numberBetween(0, 10),
            'rooms' => fake()->numberBetween(1, 10),
            'bathrooms' => fake()->numberBetween(1, 5),
            'price' => fake()->numberBetween(50000, 500000),
            'location' => fake()->city(),
            'documents' => ['deed.pdf', 'floor_plan.pdf'],
            'user_id' => User::factory(),
        ];
    }
}
