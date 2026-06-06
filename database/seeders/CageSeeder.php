<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CageSeeder extends Seeder
{
    public function run(): void
    {
        $cages = [];

        for ($i = 1; $i <= 40; $i++) {
            $cages[] = [
                'code'       => 'A-' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'name'       => 'Cage A-' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'type'       => 'standard',
                'status'     => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        for ($i = 1; $i <= 10; $i++) {
            $cages[] = [
                'code'       => 'V-' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'name'       => 'VIP Cage V-' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'type'       => 'vip',
                'status'     => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('cages')->insert($cages);
    }
}
