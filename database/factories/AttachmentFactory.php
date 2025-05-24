<?php

namespace Database\Factories;

use App\Models\ForumPost;
use App\Models\ForumReply;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attachment>
 */
class AttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fileTypes = ['pdf', 'doc', 'docx', 'jpg', 'png', 'txt', 'zip'];
        $fileType = fake()->randomElement($fileTypes);
        $fileName = fake()->word() . '.' . $fileType;
        
        return [
            'postid' => null,
            'replyid' => null,
            'file_name' => $fileName,
            'file_path' => 'uploads/attachments/' . $fileName,
            'file_type' => $fileType,
            'file_size' => fake()->numberBetween(1000, 10000000), // 1KB to 10MB
        ];
    }

    /**
     * Indicate that the attachment belongs to a forum post.
     */
    public function forPost(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'postid' => ForumPost::factory(),
                'replyid' => null,
            ];
        });
    }

    /**
     * Indicate that the attachment belongs to a forum reply.
     */
    public function forReply(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'postid' => null,
                'replyid' => ForumReply::factory(),
            ];
        });
    }
}