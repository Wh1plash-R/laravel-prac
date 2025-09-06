<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseCompletion;
use App\Models\Learner;
use App\Models\Instructor;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class InstructorController extends Controller
{
    /**
     * Display the instructor's course view with enrolled learners and management tools
     */
    public function courseView(Course $course)
    {
        // Ensure the authenticated user is an instructor for this course
        $user = Auth::user();
        $instructor = $user->instructor;

        if (!$instructor || $course->instructor_id !== $instructor->id) {
            abort(403, 'Unauthorized access to this course.');
        }

        $course->load(['learners.user', 'instructor', 'announcements', 'assignments']);

        return view('instructors.course-view', [
            'course' => $course,
            'instructor' => $instructor,
            'enrolledLearners' => $course->learners,
            'announcements' => $course->announcements()->orderBy('created_at', 'desc')->get(),
            'assignments' => $course->assignments()->orderBy('created_at', 'desc')->get(),
            'user' => $user
        ]);
    }

    /**
     * Display a listing of all courses for the instructor
     */
    public function index()
    {
        $user = Auth::user();
        $instructor = $user->instructor;

        if (!$instructor) {
            abort(403, 'Access denied. Instructor profile not found.');
        }

        $courses = Course::where('instructor_id', $instructor->id)
            ->withCount('learners')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('instructors.index', [
            'instructor' => $instructor,
            'courses' => $courses,
            'user' => $user
        ]);
    }

    /**
     * Show the edit form for an announcement
     */
    public function editAnnouncement(Announcement $announcement)
    {
        // Ensure the authenticated user is an instructor for this course
        $user = Auth::user();
        $instructor = $user->instructor;

        // Load the course relationship
        $announcement->load('course');

        if (!$instructor || $announcement->course->instructor_id !== $instructor->id) {
            abort(403, 'Unauthorized access to this announcement.');
        }

        $course = $announcement->course;
        $course->load(['learners.user', 'instructor', 'announcements', 'assignments']);

        return view('instructors.course-view', [
            'course' => $course,
            'instructor' => $instructor,
            'enrolledLearners' => $course->learners,
            'announcements' => $course->announcements()->orderBy('created_at', 'desc')->get(),
            'assignments' => $course->assignments()->orderBy('created_at', 'desc')->get(),
            'user' => $user
        ]);
    }

    /**
     * Update an existing announcement
     */
    public function updateAnnouncement(Request $request, Announcement $announcement)
    {
        // Ensure the authenticated user is an instructor for this course
        $user = Auth::user();
        $instructor = $user->instructor;

        // Load the course relationship
        $announcement->load('course');

        if (!$instructor || $announcement->course->instructor_id !== $instructor->id) {
            abort(403, 'Unauthorized access to this announcement.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:info,warning,success,important',
        ]);

        $announcement->update($validated);

        return redirect()->route('instructor.course.view', $announcement->course)
            ->with('success', 'Announcement updated successfully!');
    }

    /**
     * Delete an announcement
     */
    public function destroyAnnouncement(Announcement $announcement)
    {
        // Ensure the authenticated user is an instructor for this course
        $user = Auth::user();
        $instructor = $user->instructor;

        // Load the course relationship
        $announcement->load('course');

        if (!$instructor || $announcement->course->instructor_id !== $instructor->id) {
            abort(403, 'Unauthorized access to this announcement.');
        }

        // Store course reference before deletion
        $course = $announcement->course;

        // Delete the announcement
        $announcement->delete();

        return redirect()->route('instructor.course.view', $course)
            ->with('success', 'Announcement deleted successfully!');
    }

    /**
     * Store a new announcement (placeholder for future implementation)
     */
    public function storeAnnouncement(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:info,warning,success,important',
            'course_id' => 'required|exists:courses,id'
        ]);

        Announcement::create($validated);
        return redirect()->route('instructor.course.view', $course)
            ->with('success', 'Announcement posted successfully!');
    }

    /**
     * Store a new activity/assignment (placeholder for future implementation)
     */
    public function storeActivity(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date|after:now',
            'points' => 'nullable|integer|min:0',
            'course_id' => 'required|exists:courses,id'
        ]);

        Assignment::create($validated);

        return redirect()->route('instructor.course.view', $course)
            ->with('success', 'Activity/Assignment created successfully!');
    }

    /**
     * Show the edit form for an assignment
     */
    public function editAssignment(Assignment $assignment)
    {
        // Ensure the authenticated user is an instructor for this course
        $user = Auth::user();
        $instructor = $user->instructor;

        // Load the course relationship
        $assignment->load('course');

        if (!$instructor || $assignment->course->instructor_id !== $instructor->id) {
            abort(403, 'Unauthorized access to this assignment.');
        }

        $course = $assignment->course;
        $course->load(['learners.user', 'instructor', 'announcements', 'assignments']);

        return view('instructors.course-view', [
            'course' => $course,
            'instructor' => $instructor,
            'enrolledLearners' => $course->learners,
            'announcements' => $course->announcements()->orderBy('created_at', 'desc')->get(),
            'assignments' => $course->assignments()->orderBy('created_at', 'desc')->get(),
            'user' => $user
        ]);
    }

    /**
     * Update an existing assignment
     */
    public function updateAssignment(Request $request, Assignment $assignment)
    {
        // Ensure the authenticated user is an instructor for this course
        $user = Auth::user();
        $instructor = $user->instructor;

        // Load the course relationship
        $assignment->load('course');

        if (!$instructor || $assignment->course->instructor_id !== $instructor->id) {
            abort(403, 'Unauthorized access to this assignment.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date|after:now',
            'points' => 'nullable|integer|min:0',
        ]);

        $assignment->update($validated);

        // Check if the request came from assignment view or course view
        $referer = request()->header('referer');
        if ($referer && str_contains($referer, '/instructor/assignment/')) {
            // Came from assignment view, redirect back to assignment view
            return redirect()->route('instructor.assignment.view', $assignment)
                ->with('success', 'Assignment updated successfully!');
        }

        // Default: redirect to course view (for course view edits)
        return redirect()->route('instructor.course.view', $assignment->course)
            ->with('success', 'Assignment updated successfully!');
    }

    /**
     * Delete an assignment
     */
    public function destroyAssignment(Assignment $assignment)
    {
        // Ensure the authenticated user is an instructor for this course
        $user = Auth::user();
        $instructor = $user->instructor;

        // Load the course relationship
        $assignment->load('course');

        if (!$instructor || $assignment->course->instructor_id !== $instructor->id) {
            abort(403, 'Unauthorized access to this assignment.');
        }

        // Store course reference before deletion
        $course = $assignment->course;

        // Delete the assignment
        $assignment->delete();

        return redirect()->route('instructor.course.view', $course)
            ->with('success', 'Assignment deleted successfully!');
    }

    /**
     * View assignment details with submissions for instructor
     */
    public function viewAssignment(Assignment $assignment)
    {
        // Ensure the authenticated user is an instructor for this course
        $user = Auth::user();
        $instructor = $user->instructor;

        // Load the course relationship
        $assignment->load('course');

        if (!$instructor || $assignment->course->instructor_id !== $instructor->id) {
            abort(403, 'Unauthorized access to this assignment.');
        }

        // Load assignment with course, submissions, and related learners
        $assignment->load([
            'course.learners.user',
            'submissions.learner.user'
        ]);

        // Get all enrolled learners for this course
        $enrolledLearners = $assignment->course->learners;

        // Create a collection of learners with their submission status
        $learnersWithSubmissions = $enrolledLearners->map(function ($learner) use ($assignment) {
            $submission = $assignment->submissions->where('learner_id', $learner->id)->first();

            return (object) [
                'learner' => $learner,
                'submission' => $submission,
                'has_submitted' => $submission && $submission->isSubmitted(),
                'is_graded' => $submission && $submission->isGraded(),
                'grade' => $submission ? $submission->grade : null,
                'status' => $submission ? $submission->status : 'not_started',
                'submitted_at' => $submission ? $submission->submitted_at : null,
            ];
        });

        // Debug submission counts
        $submittedCount = $learnersWithSubmissions->where('has_submitted', true)->count();
        $gradedCount = $learnersWithSubmissions->where('is_graded', true)->count();

        return view('instructors.assignment-view', [
            'assignment' => $assignment,
            'instructor' => $instructor,
            'learnersWithSubmissions' => $learnersWithSubmissions,
            'totalLearners' => $enrolledLearners->count(),
            'submittedCount' => $submittedCount,
            'gradedCount' => $gradedCount,
            'user' => $user
        ]);
    }

    /**
     * Grade a submission
     */
    public function gradeSubmission(Request $request, Assignment $assignment)
    {
        // Ensure the authenticated user is an instructor for this course
        $user = Auth::user();
        $instructor = $user->instructor;

        // Load the course relationship
        $assignment->load('course');

        if (!$instructor || $assignment->course->instructor_id !== $instructor->id) {
            abort(403, 'Unauthorized access to this assignment.');
        }

        $validated = $request->validate([
            'learner_id' => 'required|exists:learners,id',
            'grade' => 'required|integer|min:0|max:' . $assignment->points,
            'feedback' => 'nullable|string|max:1000',
        ]);

        // Find the submission
        $submission = Submission::where('assignment_id', $assignment->id)
            ->where('learner_id', $validated['learner_id'])
            ->first();

        if (!$submission) {
            return redirect()->back()->with('error', 'No submission found for this learner.');
        }

        // Check if submission has been submitted (not just draft)
        if (!$submission->isSubmitted() && $submission->status !== 'graded') {
            return redirect()->back()->with('error', 'Cannot grade a submission that has not been submitted yet.');
        }

        // Update the submission with grade and feedback
        $submission->update([
            'grade' => $validated['grade'],
            'feedback' => $validated['feedback'],
            'status' => 'graded',
            'graded_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Grade submitted successfully!');
    }

    /**
     * Download submission file for instructor
     */
    public function downloadSubmission(Assignment $assignment, Learner $learner)
    {
        // Ensure the authenticated user is an instructor for this course
        $user = Auth::user();
        $instructor = $user->instructor;

        // Load the course relationship
        $assignment->load('course');

        if (!$instructor || $assignment->course->instructor_id !== $instructor->id) {
            abort(403, 'Unauthorized access to this assignment.');
        }

        $submission = Submission::where('assignment_id', $assignment->id)
            ->where('learner_id', $learner->id)
            ->first();

        if (!$submission || !$submission->file_path) {
            abort(404, 'File not found.');
        }

        $filePath = storage_path('app/public/' . $submission->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File not found on server.');
        }

        return response()->download($filePath, $submission->file_name);
    }

    /**
     * Lock an assignment (prevent further submissions)
     */
    public function lockAssignment(Assignment $assignment)
    {
        // Ensure the authenticated user is an instructor for this course
        $user = Auth::user();
        $instructor = $user->instructor;

        // Load the course relationship
        $assignment->load('course');

        if (!$instructor || $assignment->course->instructor_id !== $instructor->id) {
            abort(403, 'Unauthorized access to this assignment.');
        }

        $assignment->update(['status' => 'locked']);

        return redirect()->back()->with('success', 'Assignment has been locked. Students can no longer submit work.');
    }

    /**
     * Unlock an assignment (allow submissions)
     */
    public function unlockAssignment(Assignment $assignment)
    {
        // Ensure the authenticated user is an instructor for this course
        $user = Auth::user();
        $instructor = $user->instructor;

        // Load the course relationship
        $assignment->load('course');

        if (!$instructor || $assignment->course->instructor_id !== $instructor->id) {
            abort(403, 'Unauthorized access to this assignment.');
        }

        $assignment->update(['status' => 'active']);

        return redirect()->back()->with('success', 'Assignment has been unlocked. Students can now submit work.');
    }

    /**
     * Promote students - finalize grades and complete the course
     */
    public function promoteStudents(Course $course)
    {
        // Ensure the authenticated user is an instructor for this course
        $user = Auth::user();
        $instructor = $user->instructor;

        if (!$instructor || $course->instructor_id !== $instructor->id) {
            abort(403, 'Unauthorized access to this course.');
        }

        // Get all enrolled learners
        $enrolledLearners = $course->learners;

        if ($enrolledLearners->count() === 0) {
            return redirect()->back()->with('error', 'No students are enrolled in this course.');
        }

        // Get all assignments for this course
        $assignments = $course->assignments;
        $totalAssignments = $assignments->count();
        $totalPoints = $assignments->sum('points');

        if ($totalAssignments === 0) {
            return redirect()->back()->with('error', 'Cannot promote students without any assignments.');
        }

        $promotedCount = 0;

        // Process each enrolled learner
        foreach ($enrolledLearners as $learner) {
            // Get all submissions for this learner in this course
            $submissions = Submission::where('learner_id', $learner->id)
                ->whereIn('assignment_id', $assignments->pluck('id'))
                ->where('status', 'graded')
                ->get();

            // Calculate grades
            $totalPointsEarned = $submissions->sum('grade');
            $assignmentsCompleted = $submissions->count();

            // Calculate final grade as percentage
            $finalGrade = $totalPoints > 0 ? ($totalPointsEarned / $totalPoints) * 100 : 0;

            // Create course completion record
            CourseCompletion::create([
                'course_id' => $course->id,
                'learner_id' => $learner->id,
                'final_grade' => round($finalGrade, 2),
                'total_points_earned' => $totalPointsEarned,
                'total_points_possible' => $totalPoints,
                'assignments_completed' => $assignmentsCompleted,
                'total_assignments' => $totalAssignments,
                'completed_at' => now(),
            ]);

            $promotedCount++;
        }

        // Remove all learners from the course (they're now completed)
        $course->learners()->detach();

        // Delete all announcements for this course
        $course->announcements()->delete();

        // Delete all assignments and their submissions for this course
        foreach ($assignments as $assignment) {
            // Delete submissions first (due to foreign key constraints)
            $assignment->submissions()->delete();
            // Then delete the assignment
            $assignment->delete();
        }

        return redirect()->back()->with('success',
            "Successfully promoted {$promotedCount} students. Course has been reset for the next batch.");
    }

}
