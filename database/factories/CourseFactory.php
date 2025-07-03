<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


     protected $courses_description = [
        "Learn the basics.",
        "Explore the concepts and its applications.",
        "Understand for efficient problem solving.",
        "Study in computer science.",
        "Dive into techniques and their practical applications.",
     ];

     protected $courses_department = [
        "Computer Science",
        "Mathematics",
        "Engineering",
        "Physics",
     ];

    public function definition(): array
    {
        return [
            'description' => fake()->randomElement($this->courses_description),
            'department' => fake()->randomElement($this->courses_department),
            //
        ];
    }
}
