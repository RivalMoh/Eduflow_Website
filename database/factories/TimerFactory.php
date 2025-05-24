<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Timer>
 */
class TimerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = fake()->dateTimeBetween('-1 month', 'now');
        $endTime = clone $startTime;
        $endTime->modify('+' . rand(15, 120) . ' minutes');
        
        return [
            'user_id' => User::factory(),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'duration' => $endTime->getTimestamp() - $startTime->getTimestamp(),
        ];
    }

    /**
     * Indicate that the timer is still running.
     */
    public function running(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'end_time' => null,
                'duration' => 0,
            ];
        });
    }
}

