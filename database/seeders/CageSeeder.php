<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cage;

class CageSeeder extends Seeder
{
    public function run(): void
    {
        Cage::insert([
            [
                'name' => 'Cage A1',
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cage A2',
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cage VIP 1',
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cage VIP 2',
                'status' => 'locked',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}