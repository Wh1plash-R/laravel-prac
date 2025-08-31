<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assignment>
 */
class AssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $assignmentTitles = [
            'Introduction Assignment',
            'Research Paper',
            'Group Project',
            'Final Exam',
            'Case Study Analysis',
            'Lab Report',
            'Presentation',
            'Quiz',
            'Homework Assignment',
            'Portfolio Submission',
            'Literature Review',
            'Data Analysis Project',
            'Creative Project',
            'Reflection Paper',
            'Technical Report',
        ];

        $assignmentDescriptions = [
            'Introduction Assignment' => 'Complete the introductory exercises and submit your responses. This assignment will help you get familiar with the course concepts.',
            'Research Paper' => 'Write a comprehensive research paper on a topic of your choice related to the course material. Include proper citations and references.',
            'Group Project' => 'Work collaboratively with your team members to complete this project. Each member should contribute equally to the final submission.',
            'Final Exam' => 'This comprehensive exam will test your understanding of all course materials covered throughout the semester.',
            'Case Study Analysis' => 'Analyze the provided case study and submit a detailed analysis including recommendations and conclusions.',
            'Lab Report' => 'Complete the laboratory exercise and submit a detailed report including methodology, results, and conclusions.',
            'Presentation' => 'Prepare and deliver a presentation on your chosen topic. Include visual aids and be prepared for questions.',
            'Quiz' => 'Complete this short quiz to test your understanding of the recent course material.',
            'Homework Assignment' => 'Complete the assigned problems and submit your solutions. Show all your work for full credit.',
            'Portfolio Submission' => 'Compile your best work from the semester into a portfolio that demonstrates your learning and growth.',
            'Literature Review' => 'Conduct a thorough review of the literature on your chosen topic and submit a comprehensive analysis.',
            'Data Analysis Project' => 'Analyze the provided dataset and submit a report with your findings, visualizations, and conclusions.',
            'Creative Project' => 'Create a creative project that demonstrates your understanding of the course concepts in an innovative way.',
            'Reflection Paper' => 'Write a reflection paper on your learning experience and how the course has impacted your understanding.',
            'Technical Report' => 'Write a technical report on your project or research findings. Follow proper technical writing conventions.',
        ];

        $title = fake()->randomElement($assignmentTitles);
        $dueDate = fake()->dateTimeBetween('now', '+60 days');

        return [
            'course_id' => Course::factory(),
            'title' => $title,
            'description' => $assignmentDescriptions[$title] ?? fake()->paragraph(),
            'due_date' => $dueDate,
            'status' => 'active', // Default to active, can be overridden in seeder
            'points' => fake()->randomElement([50, 75, 100, 150, 200]),
            'created_at' => fake()->dateTimeBetween('-30 days', 'now'),
            'updated_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
