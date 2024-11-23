<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::insert([
            ['name' => 'Ahmed Tarek', 'phone' => '01212123456'],
            ['name' => 'Omar Ali', 'phone' => '01121212345'],
            ['name' => 'Mohamed Gamal', 'phone' => '01000234123'],
        ]);
    }
}