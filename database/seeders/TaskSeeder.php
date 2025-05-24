<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskBoard;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users and tags
        $users = User::all();
        $tags = Tag::all();

        if ($users->isEmpty()) {
            $this->command->info('No users found. Please run UserSeeder first.');
            return;
        }

        foreach ($users as $user) {
            // Get task boards for this user
            $taskBoards = TaskBoard::where('user_id', $user->id)->get();
            
            if ($taskBoards->isNotEmpty()) {
                foreach ($taskBoards as $taskBoard) {
                    // Create 3-10 tasks for each task board
                    $tasks = \App\Models\Task::factory()
                        ->count(rand(3, 10))
                        ->create([
                            'user_id' => $user->id,
                            'task_board_id' => $taskBoard->id,
                        ]);
                    
                    // Attach random tags to tasks if tags exist
                    if ($tags->isNotEmpty()) {
                        foreach ($tasks as $task) {
                            $task->tags()->attach(
                                $tags->random(rand(0, min(3, $tags->count())))->pluck('id')->toArray()
                            );
                        }
                    }
                }
            }
            
            // Create some tasks without board
            $tasks = \App\Models\Task::factory()
                ->count(rand(2, 5))
                ->create([
                    'user_id' => $user->id,
                    'task_board_id' => null,
                ]);

            // Attach random tags to tasks without board if tags exist
            if ($tags->isNotEmpty()) {
                foreach ($tasks as $task) {
                    $task->tags()->attach(
                        $tags->random(rand(0, min(3, $tags->count())))->pluck('id')->toArray()
                    );
                }
            }
        }
    }
}
