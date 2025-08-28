<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProgress>
 */
class UserProgressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['not_started', 'in_progress', 'completed'];
        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'problem_id' => \App\Models\Problem::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement($statuses),
            'attempts' => $this->faker->numberBetween(0, 10),
            'best_score' => $this->faker->optional()->numberBetween(0, 100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
