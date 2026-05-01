<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@pawresort.com'],
            [
                'name'     => 'Admin PawResort',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]
        );

        // Sample user
        User::firstOrCreate(
            ['email' => 'user@pawresort.com'],
            [
                'name'     => 'PawUser',
                'password' => Hash::make('user123'),
                'role'     => 'user',
            ]
        );
    }
}