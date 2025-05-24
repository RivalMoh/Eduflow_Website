<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $colors = ['#3490dc', '#38c172', '#e3342f', '#f6993f', '#9561e2'];
        
        return [
            'name' => fake()->unique()->word(),
            'color' => fake()->randomElement($colors),
        ];
    }
}