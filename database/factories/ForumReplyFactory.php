<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\ForumPost;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ForumReply>
 */
class ForumReplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'postid' => ForumPost::factory(),
            'user_id' => User::factory(),
            'content' => fake()->paragraphs(rand(1, 3), true),
        ];
    }
}
