<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
use App\Models\ForumPost;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ForumPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users and tags
        $users = User::all();
        $tags = Tag::all();
        
        // Create 15-25 forum posts with random authors
        $posts = ForumPost::factory()
                ->count(rand(15, 25))
                ->create([
                    'user_id' => function () use ($users) {
                        return $users->random()->id;
                    }
                ]);
                
        // Attach random tags to posts
        foreach ($posts as $post) {
            $post->tags()->attach(
                $tags->random(rand(0, 4))->pluck('id')->toArray()
            );
        }
    }
}
