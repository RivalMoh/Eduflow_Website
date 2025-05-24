<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create common tags
        $tags = [
            ['name' => 'important', 'color' => '#e3342f'],
            ['name' => 'study', 'color' => '#3490dc'],
            ['name' => 'homework', 'color' => '#38c172'],
            ['name' => 'exam', 'color' => '#f6993f'],
            ['name' => 'research', 'color' => '#9561e2'],
            ['name' => 'project', 'color' => '#f66d9b'],
            ['name' => 'meeting', 'color' => '#6574cd'],
            ['name' => 'personal', 'color' => '#4dc0b5'],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }

        // Create some random tags
        Tag::factory()->count(7)->create();
    }
}