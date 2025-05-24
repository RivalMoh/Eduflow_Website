<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users and tags
        $users = User::all();
        $tags = Tag::all();

        foreach ($users as $user) {
            // Create 5-15 notes for each user
            $notes = Note::factory()
                ->count(rand(5, 15))
                ->create(['user_id' => $user->id]);
                
            // Attach random tags to notes
            foreach ($notes as $note) {
                $note->tags()->attach(
                    $tags->random(rand(0, 3))->pluck('id')->toArray()
                );
            }
        }
    }
}