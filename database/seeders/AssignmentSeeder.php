<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Assignment;
use Illuminate\Database\Seeder;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all existing courses
        $courses = Course::all();

        foreach ($courses as $course) {
            // Create 2-6 assignments for each course with logical progression
            $assignmentCount = fake()->numberBetween(2, 6);

            for ($i = 0; $i < $assignmentCount; $i++) {
                // Create assignments with increasing due dates
                $dueDate = fake()->dateTimeBetween('now', '+' . (30 + ($i * 15)) . ' days');

                // Determine status based on due date logic:
                // - Active: Due within next 2 weeks (14 days)
                // - Locked: Due more than 2 weeks away or in the past
                $daysUntilDue = now()->diffInDays($dueDate, false); // false = absolute value

                if ($daysUntilDue <= 14 && $daysUntilDue >= 0) {
                    $status = 'active';
                } else {
                    $status = 'locked';
                }

                Assignment::factory()->create([
                    'course_id' => $course->id,
                    'status' => $status,
                    'due_date' => $dueDate,
                ]);
            }
        }
    }
}
