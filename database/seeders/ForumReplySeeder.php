<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ForumPost;
use App\Models\ForumReply;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ForumReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users and forum posts
        $users = User::all();
        $posts = ForumPost::all();

        foreach ($posts as $post) {
            // Create 0-10 replies for each post
            ForumReply::factory()
                ->count(rand(0, 10))
                ->create([
                    'postid' => $post->postid,
                    'user_id' => function () use ($users) {
                        return $users->random()->id;
                    }
                ]);
        }
    }
}