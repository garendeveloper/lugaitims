<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier_Items>
 */
class Supplier_ItemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = random_int(20, 100);
        $cost = random_int(1500, 20000);
        $totalCost = $quantity*$cost;
        return [
            'category_id'=> random_int(1,3),
            'supplier_id' => random_int(1, 5),
            'item_id' => random_int(1, 10),
            'modelnumber'=> strtoupper(Str::random(11)),
            'serialnumber'=> strtoupper(Str::random(11)),
            'stock' => random_int(100, 5000),
            'quantity' => $quantity,
            'cost'=> $cost,
            'totalCost' => $totalCost,
            'status'=>1,
        ];
    }
}
