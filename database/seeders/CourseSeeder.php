<?php

namespace Database\Seeders;

use App\Models\Course;
use Database\Factories\CourseFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $courses_title = [
        "Introduction to Programming",
        "Linear Algebra",
        "Data Structures and Algorithms",
        "Automata Theory and Formal Languages",
        "Machine Learning",
     ];

        foreach ($courses_title as $title) {
            Course::factory()->create([
                'title' => $title,
                'description' => CourseFactory::new()->definition()['description'],
                'department' => CourseFactory::new()->definition()['department'],
            ]);
        }
    }
}
