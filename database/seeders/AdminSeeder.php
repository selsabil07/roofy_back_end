<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Roofy API: Seeds default admin account for the admin dashboard.
 * Fixed updateOrCreate — only email is the lookup key.
 */
class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'userName' => 'admin',
                'password' => Hash::make('admin123'),
                'role' => User::ROLE_ADMIN,
                'phone' => '0000000000',
                'address' => 'Roofy HQ',
            ]
        );
    }
}
