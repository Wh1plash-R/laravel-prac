<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use App\Models\Instructor;
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

        $courses_description = [
            "Introduction to Programming" => "Learn the basics of programming.",
            "Linear Algebra" => "Explore the concepts and its applications.",
            "Data Structures and Algorithms" => "Understand for efficient problem solving.",
            "Automata Theory and Formal Languages" => "Get familiar with the theory of computation.",
            "Machine Learning" => "Dive into techniques and their practical applications.",
         ];

         $instructors = Instructor::whereIn(
            'user_id',
            User::where('role_id', 3)->pluck('id')
        )->pluck('id')->shuffle();


        $courses_count = min(count($courses_title), $instructors->count());

        for ($i = 0; $i < $courses_count; $i++) {
            $title = $courses_title[$i];
            $instructorId = $instructors[$i]; // one unique instructor per course

            Course::factory()->create([
                'title' => $title,
                'description' => $courses_description[$title],
                'department' => $title === "Linear Algebra" ? "Mathematics" : "Computer Science",
                'instructor_id' => $instructorId,
            ]);
        }
    }
}
