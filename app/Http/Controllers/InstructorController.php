<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Learner;
use App\Models\Instructor;
use App\Models\Assignment;
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


}
