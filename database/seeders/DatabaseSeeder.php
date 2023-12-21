<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Position::factory()->create([
            'position' => 'PROPERTY CUSTODIAN',
        ]);
        \App\Models\Position::factory()->create([
            'position' => 'TEACHER',
        ]);
        \App\Models\Position::factory()->create([
            'position' => 'PRINCIPAL',
        ]);
        \App\Models\Position::factory()->create([
            'position' => 'STUDENT',
        ]);

        \App\Models\Department::factory()->create([
            'department_name' => 'SUPPLY/PROCUREMENT OFFICE',
        ]);
        \App\Models\Department::factory()->create([
            'department_name' => 'SENIOR HIGH BUILDING',
        ]);
        \App\Models\Department::factory()->create([
            'department_name' => 'ICT BUILDING',
        ]);
        \App\Models\Department::factory()->create([
            'department_name' => 'HOME ECONOMICS BUILDING',
        ]);



        \App\Models\User::factory()->create([
            'role' => 1,
            'fullname' => strtoupper('VINCENT JHANREY S. JALALON'),
            'department_id' => 1,
            'position_id' => 1,
            'contact_number' => '+63988765145',
            'username' => 'admin',
            'email' => 'vincentjhanrey.jalalon@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => '',
        ]);

        \App\Models\User::factory()->create([
            'role' => 2,
            'fullname' => strtoupper('JOHN BENCH B. CUY'),
            'department_id' => 1,
            'position_id' => 2,
            'contact_number' => '+63988765145',
            'username' => 'purchaser',
            'email' => 'johnvince.capstone@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => '',
        ]);

        \App\Models\User::factory(3)->create();
        
        \App\Models\ItemCategory::factory()->create([
            'category' => 'CONSUMABLE',
            'status' => 1,
        ]);
        \App\Models\ItemCategory::factory()->create([
            'category' => 'SEMI EXPANDABLE',
            'status' => 1,
        ]);
        \App\Models\ItemCategory::factory()->create([
            'category' => 'CAPITAL OUTLAY',
            'status' => 1,
        ]);

        \App\Models\Supplier::factory(5)->create();
        \App\Models\Item::factory(10)->create();
        \App\Models\Supplier_Items::factory(10)->create();
    }
}
