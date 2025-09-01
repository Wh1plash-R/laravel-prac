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
}
