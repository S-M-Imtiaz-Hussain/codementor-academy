<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LearningPath>
 */
class LearningPathFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $levels = ['beginner', 'intermediate', 'advanced'];
        return [
            'name' => $this->faker->catchphrase(),
            'description' => $this->faker->paragraph(3),
            'difficulty_level' => $this->faker->randomElement($levels),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
