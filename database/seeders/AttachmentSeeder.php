<?php

namespace Database\Seeders;

use App\Models\ForumPost;
use App\Models\Attachment;
use App\Models\ForumReply;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AttachmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get forum posts and replies
        $posts = ForumPost::all();
        $replies = ForumReply::all();

        // Add attachments to some posts
        foreach ($posts as $post) {
            // 30% chance to have attachments
            if (rand(1, 100) <= 30) {
                Attachment::factory()
                    ->count(rand(1, 3))
                    ->create([
                        'postid' => $post->postid,
                        'replyid' => null,
                    ]);
            }
        }

        // Add attachments to some replies
        foreach ($replies as $reply) {
            // 20% chance to have attachments
            if (rand(1, 100) <= 20) {
                Attachment::factory()
                    ->count(rand(1, 2))
                    ->create([
                        'postid' => null,
                        'replyid' => $reply->replyid,
                    ]);
            }
        }
    }
}
