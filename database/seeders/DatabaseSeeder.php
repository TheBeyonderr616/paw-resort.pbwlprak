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
        User::updateOrCreate(
            ['email' => 'admin@pawresort.com'],
            [
                'name'     => 'Admin PawResort',
                'password' => 'admin123',
                'role'     => 'admin',
            ]
        );

        // ── SAMPLE USER ────────────────────────────
        User::updateOrCreate(
            ['email' => 'user@pawresort.com'],
            [
                'name'     => 'PawUser',
                'password' => 'user123',
                'role'     => 'user',
            ]
        );

        // ── CAGE SEED (INI YANG BARU WAJIB) ───────
        $this->call([
            CageSeeder::class,
        ]);
    }
}