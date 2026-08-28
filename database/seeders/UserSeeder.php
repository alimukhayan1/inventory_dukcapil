<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role' => UserRole::ADMIN,
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Petugas Inventaris',
            'email' => 'petugas@example.com',
            'password' => 'password',
            'role' => UserRole::PETUGAS,
            'is_active' => true,
        ]);
    }
}
