<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Learner>
 */
class LearnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=> fake('en_JP')->name(),
            'skill'=> fake()->word(),
            'bio'=> fake()->realText(30),
            'course_id' => Course::inRandomOrder()->first()->id, // Assuming you have a Course model and courses seeded
            // fake()->numberBetween(1, 5), // Assuming you have 5 courses seeded
        ];
    }
}
