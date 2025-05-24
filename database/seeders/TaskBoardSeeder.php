<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TaskBoard;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaskBoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users except admin
        $users = User::where('role', 'user')->get();

        foreach ($users as $user) {
            // Create default boards for each user
            TaskBoard::create([
                'user_id' => $user->id,
                'name' => 'Personal Tasks',
                'description' => 'Board for personal tasks and activities',
            ]);
            
            TaskBoard::create([
                'user_id' => $user->id,
                'name' => 'Study',
                'description' => 'Academic tasks and study plans',
            ]);
            
            // Create some random boards
            TaskBoard::factory()
                ->count(rand(0, 2))
                ->create(['user_id' => $user->id]);
        }
    }
}