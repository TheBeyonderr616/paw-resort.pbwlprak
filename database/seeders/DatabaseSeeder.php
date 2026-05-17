<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── ADMIN USER ─────────────────────────────
        User::firstOrCreate(
            ['email' => 'admin@pawresort.com'],
            [
                'name'     => 'Admin PawResort',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]
        );

        // ── SAMPLE USER ────────────────────────────
        User::firstOrCreate(
            ['email' => 'user@pawresort.com'],
            [
                'name'     => 'PawUser',
                'password' => Hash::make('user123'),
                'role'     => 'user',
            ]
        );

        // ── CAGE SEED (INI YANG BARU WAJIB) ───────
        $this->call([
            CageSeeder::class,
        ]);
    }
}