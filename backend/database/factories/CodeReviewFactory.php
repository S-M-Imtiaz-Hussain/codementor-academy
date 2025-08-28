<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CodeReview>
 */
class CodeReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'submission_id' => \App\Models\Submission::inrandomOrder()->first()->id,
            'reviewer_id' => \App\Models\User::inRandomOrder()->first()->id,
            'feedback' => $this->faker->paragraph(2),
            'ai_suggestions' => json_encode([
                'optimizeLoops' => true,
                'improveReadability' => true,
                'reduceMemoryUsage' => false,
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
