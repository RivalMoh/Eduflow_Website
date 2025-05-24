<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'username' => 'admin',
            'email' => 'admin@eduflow.com',
            'role' => 'admin',
            'password' => Hash::make('password123'),
            'remember_token' => Str::random(10)
        ]);

        // Create regular user
        User::create([
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'role' => 'user',
            'password' => Hash::make('password123'),
            'remember_token' => Str::random(10)
        ]);

        // Create sample users
        User::factory()->count(8)->create();
    }
}
