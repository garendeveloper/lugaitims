<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use DB;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RequestingItemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $movement_id = random_int(1, 10);
        $check = DB::select('select * from requesting_items where movement_id != '.$movement_id.'');
        if(empty($check)) 
        {
            return [
                'movement_id'=>$movement_id,
                'user_id'=>random_int(1, 4),
                'qty'=>0,
                'status'=>1,
                'notification'=>1
            ];
        }
       
    }
}
