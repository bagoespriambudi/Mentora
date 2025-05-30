<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@mentora.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create sample tutor
        User::create([
            'name' => 'Sample tutor',
            'email' => 'tutor@mentora.com',
            'password' => Hash::make('password'),
            'role' => 'tutor',
            'is_active' => true,
        ]);

        // Create sample tutee
        User::create([
            'name' => 'Sample tutee',
            'email' => 'tutee@mentora.com',
            'password' => Hash::make('password'),
            'role' => 'tutee',
            'is_active' => true,
        ]);
    }
}
