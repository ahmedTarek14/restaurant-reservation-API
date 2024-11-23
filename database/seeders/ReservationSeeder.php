<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Reservation::insert([
            [
                'table_id' => 1,
                'customer_id' => 1,
                'from_time' => now()->addHours(1),
                'to_time' => now()->addHours(3),
            ],
            [
                'table_id' => 2,
                'customer_id' => 2,
                'from_time' => now()->addHours(2),
                'to_time' => now()->addHours(4),
            ],
        ]);
    }
}