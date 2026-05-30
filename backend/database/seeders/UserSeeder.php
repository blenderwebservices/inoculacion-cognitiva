<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@habanero.com'],
            [
                'name' => 'Admin Habanero',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Regular user
        User::firstOrCreate(
            ['email' => 'user@habanero.com'],
            [
                'name' => 'Piloto HCS',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );
    }
}
