<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mentorship>
 */
class MentorshipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $statuses = ['pending', 'active', 'completed', 'cancelled'];
        $mentor = \App\Models\User::where('role','mentor')->inRandomOrder()->first();
        $student = \App\Models\User::where('role','student')->inRandomOrder()->first();
        return [

            'mentor_id' => $mentor ? $mentor->id : \App\Models\User::where('role','mentor')->first()->id,
            'student_id' => $student ? $student->id : \App\Models\User::where('role','student')->first()->id,
            'status' => $this->faker->randomElement($statuses),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
