<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PathProblem>
 */
class PathProblemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\PathProblems::class;

    public function definition(): array
    {
        return [
            'path_id' => \App\Models\LearningPath::inRandomOrder()->first()->id,
            'problem_id' => \App\Models\Problem::inrandomOrder()->first()->id,
            'order' => $this->faker->numberBetween(1, 10),
            'is_required' => $this->faker->boolean(90),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
