<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

    // Admin
    User::create([
        'username' => 'admin',
        'name' => 'Administrator',
        'email' => 'admin@example.com',
        'password' => Hash::make('123456'),
        'role' => 'admin',
    ]);

    // Manager
    User::create([
        'username' => 'manager',
        'name' => 'Manager User',
        'email' => 'manager@example.com',
        'password' => Hash::make('123456'),
        'role' => 'manager',
    ]);

    // User Biasa
    User::create([
        'username' => 'ilham',
        'name' => 'ilham',
        'email' => 'milham1358@gmail.com',
        'password' => Hash::make('123456'),
        'role' => 'user',
    ]);
    }
}
