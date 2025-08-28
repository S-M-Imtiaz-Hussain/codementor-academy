<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Submission>
 */
class SubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $status = ['pending','accepted','rejected'];
        $languages = ['php','python','javascript','java','c++','c#','ruby','go','swift'];
        
        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'problem_id' => \App\Models\Problem::inRandomOrder()->first()->id,
            'code' => $this->faker->randomHtml(),
            'status' => $this->faker->randomElement($status),
            'language' => $this->faker->randomElement($languages),
            'score' => $this->faker->numberBetween(0, 100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
