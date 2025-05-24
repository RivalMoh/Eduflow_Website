<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Timer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TimerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users
        $users = User::all();

        foreach ($users as $user) {
            // Create 5-20 completed timer sessions for each user
            Timer::factory()
                ->count(rand(5, 20))
                ->create(['user_id' => $user->id]);
                
            // Maybe create 1 running timer session
            if (rand(0, 1)) {
                Timer::factory()
                    ->running()
                    ->create(['user_id' => $user->id]);
            }
        }
    }
}