<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Announcement>
 */
class AnnouncementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $announcementTypes = [
            'info' => [
                'Welcome to the Course!',
                'Course Materials Updated',
                'New Resources Available',
                'Office Hours Announced',
                'Course Schedule Update',
            ],
            'warning' => [
                'Assignment Due Reminder',
                'Important Deadline Approaching',
                'Required Reading Update',
                'Exam Schedule Change',
                'Submission Guidelines Update',
            ],
            'success' => [
                'Congratulations on Progress!',
                'Course Milestone Achieved',
                'Excellent Work Recognition',
                'Project Successfully Completed',
                'Learning Goals Met',
            ],
            'important' => [
                'Critical Course Update',
                'Emergency Schedule Change',
                'Required Action Needed',
                'System Maintenance Notice',
                'Important Policy Update',
            ],
        ];

        $type = fake()->randomElement(array_keys($announcementTypes));
        $title = fake()->randomElement($announcementTypes[$type]);

        $descriptions = [
            'Welcome to the Course!' => 'We\'re excited to have you join us. Please review the course materials and don\'t hesitate to ask questions.',
            'Course Materials Updated' => 'New study materials have been uploaded to the course portal. Please review them before the next session.',
            'New Resources Available' => 'Additional learning resources including videos, articles, and practice exercises are now available.',
            'Office Hours Announced' => 'I will be available for office hours every Tuesday and Thursday from 2-4 PM. Feel free to drop by with questions.',
            'Course Schedule Update' => 'There has been a minor adjustment to the course schedule. Please check the updated timeline.',
            'Assignment Due Reminder' => 'Don\'t forget that the assignment is due next week. Make sure to submit it on time to avoid late penalties.',
            'Important Deadline Approaching' => 'The deadline for the major project is approaching. Please ensure all components are completed.',
            'Required Reading Update' => 'The required reading list has been updated. Please download the new materials from the course portal.',
            'Exam Schedule Change' => 'The exam schedule has been modified. Please check the new dates and times.',
            'Submission Guidelines Update' => 'Please review the updated submission guidelines before submitting your assignments.',
            'Congratulations on Progress!' => 'Great job on completing the recent module! Your understanding of the concepts is excellent.',
            'Course Milestone Achieved' => 'The class has successfully reached an important milestone. Keep up the great work!',
            'Excellent Work Recognition' => 'Several students have submitted outstanding work. Your dedication to learning is commendable.',
            'Project Successfully Completed' => 'The group project has been completed successfully. Well done to all participants!',
            'Learning Goals Met' => 'The class has collectively met the learning objectives for this section. Excellent progress!',
            'Critical Course Update' => 'This is a critical update that requires immediate attention. Please read carefully.',
            'Emergency Schedule Change' => 'Due to unforeseen circumstances, there will be a change in the course schedule.',
            'Required Action Needed' => 'Your immediate action is required. Please respond to this announcement as soon as possible.',
            'System Maintenance Notice' => 'The course portal will be under maintenance. Please plan accordingly.',
            'Important Policy Update' => 'There has been an important update to the course policies. Please review carefully.',
        ];

        return [
            'course_id' => Course::factory(),
            'title' => $title,
            'description' => $descriptions[$title] ?? fake()->paragraph(),
            'type' => $type,
            'created_at' => fake()->dateTimeBetween('-30 days', 'now'),
            'updated_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
