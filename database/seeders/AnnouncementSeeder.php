<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all existing courses
        $courses = Course::all();

        foreach ($courses as $course) {
            // Create 3-8 announcements for each course
            Announcement::factory(fake()->numberBetween(3, 8))->create([
                'course_id' => $course->id,
            ]);
        }
    }
}
