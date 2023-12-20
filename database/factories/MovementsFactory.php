<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MovementsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            'user_id'=>2,
            'supplieritem_id'=> random_int(1, 10),
            'dateReleased'=> $this->faker->dateTimeBetween('-5 years', 'now'),
            'date'=> $this->faker->dateTimeBetween('-5 years', 'now'),
            'datePurchased'=>$this->faker->dateTimeBetween('-5 years', 'now'),
            'dateWasted'=> $this->faker->dateTimeBetween('-5 years', 'now'),
            'dateCancelled'=> $this->faker->dateTimeBetween('-5 years', 'now'),
            'type'=> 2,
            'lastAction' => 'JOHN VINCE B. CUY',
        ];
    }
}
