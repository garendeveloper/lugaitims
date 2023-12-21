<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = random_int(100, 500);
        $cost = random_int(100, 1000);
        return [
            'item' => strtoupper($this->faker->word),
            'unit' => $this->faker->randomElement(['RIM', 'PCS', 'ML', 'L', 'KG', 'PC']),
            'brand' => strtoupper($this->faker->word),
        ];
    }
}
