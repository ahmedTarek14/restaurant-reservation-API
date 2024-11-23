<?php

namespace Database\Seeders;

use App\Models\WaitingList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WaitingListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WaitingList::insert([
            ['customer_id' => 3, 'added_at' => now()],
        ]);
    }
}