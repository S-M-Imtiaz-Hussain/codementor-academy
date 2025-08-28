<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Problem>
 */
class ProblemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $difficulty = ['easy', 'medium', 'hard'];
        $categories = ['arrays', 'strings', 'math', 'dynamic programming', 'graphs', 'trees', 'sorting', 'searching'];
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'difficulty' => $this->faker->randomElement($difficulty),
            'category' => $this->faker->randomElement($categories),
            'test_cases' => json_encode([
                [
                    'input' => $this->faker->words(3, true),
                    'output' => $this->faker->word(),
                ],
                [
                    'input' => $this->faker->words(3, true),
                    'output' => $this->faker->word(),
                ],
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
