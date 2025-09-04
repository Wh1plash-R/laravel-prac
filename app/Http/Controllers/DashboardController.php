<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Learner;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if($user->isAdmin())
        {
            $redirect = redirect()->route('learners.index');
            if (session()->has('success')) {
                $redirect = $redirect->with('success', session('success'));
            }
            return $redirect;
        }
        elseif($user->isInstructor())
        {
            return redirect()->route('instructor.index');
        }

        // Eager load courses and assignments for accurate progress computation
        $learner = Learner::with(['courses.assignments'])->firstWhere('user_id', $user->id); // firstWhere() = where()->first()
        $courses = Course::all();
        $learner_courses = $learner?->courses; // This is called "null safe" operator just like "$learner? learner -> course: null"
        $course = $learner_courses?->first(); // what's the point of this?

        // --- Dynamic Stats ---
        $coursesEnrolled = $learner_courses?->count() ?? 0;

        // Collect all assignment IDs from enrolled courses
        $assignmentIds = $learner_courses
            ? $learner_courses->flatMap(fn ($c) => $c->assignments->pluck('id'))
            : collect();

        $totalAssignments = $assignmentIds->count();

        // Count learner submissions that are submitted or graded
        $completedSubmissions = 0;
        if ($learner && $totalAssignments > 0) {
            $completedSubmissions = Submission::where('learner_id', $learner->id)
                ->whereIn('assignment_id', $assignmentIds)
                ->whereIn('status', ['submitted', 'graded'])
                ->count();
        }

        // Average progress across all enrolled courses (based on assignments completed out of total assignments)
        $averageProgress = $totalAssignments > 0
            ? round(($completedSubmissions / $totalAssignments) * 100)
            : 0;

        // Hours learned proxy: assume 1 hour per completed submission (simple proxy until time-tracking is added)
        $hoursLearned = $completedSubmissions;

        // Per-course progress map: [course_id => percent]
        $courseProgress = [];
        if ($learner_courses && $learner_courses->count() > 0) {
            // Fetch all submissions for this learner once
            $learnerSubmissionQuery = Submission::where('learner_id', $learner?->id)
                ->whereIn('status', ['submitted', 'graded']);

            // For each course, compute progress based on its assignments
            foreach ($learner_courses as $lc) {
                $courseAssignmentIds = $lc->assignments->pluck('id');
                $courseTotalAssignments = $courseAssignmentIds->count();
                if ($courseTotalAssignments === 0) {
                    $courseProgress[$lc->id] = 0;
                    continue;
                }

                $courseCompleted = (clone $learnerSubmissionQuery)
                    ->whereIn('assignment_id', $courseAssignmentIds)
                    ->count();

                $courseProgress[$lc->id] = (int) round(($courseCompleted / $courseTotalAssignments) * 100);
            }
        }

        // --- Dynamic Achievements ---
        $achievementsEarned = [];
        // Define rules and presentation
        $possibleAchievements = [
            [
                'id' => 'getting_started',
                'title' => 'Getting Started',
                'description' => 'Enrolled in your first course or made your first submission',
                'earned' => ($coursesEnrolled > 0) || ($hoursLearned > 0) || ($averageProgress > 0),
                'bg' => 'from-blue-50 to-cyan-50',
                'border' => 'border-blue-100',
                'iconBg' => 'from-blue-500 to-cyan-500',
                'iconPath' => 'M13 10V3L4 14h7v7l9-11h-7z',
            ],
            [
                'id' => 'course_explorer',
                'title' => 'Course Explorer',
                'description' => 'Enrolled in 3+ courses',
                'earned' => ($coursesEnrolled >= 3),
                'bg' => 'from-yellow-50 to-orange-50',
                'border' => 'border-yellow-100',
                'iconBg' => 'from-yellow-400 to-orange-500',
                'iconPath' => 'M12 20l9-5-9-5-9 5 9 5zm0-12l9-5-9-5-9 5 9 5z',
            ],
            [
                'id' => 'high_achiever',
                'title' => 'High Achiever',
                'description' => 'Maintains 75%+ average progress',
                'earned' => ($averageProgress >= 75),
                'bg' => 'from-purple-50 to-pink-50',
                'border' => 'border-purple-100',
                'iconBg' => 'from-purple-500 to-pink-500',
                'iconPath' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
            ],
            [
                'id' => 'consistent',
                'title' => 'Consistent',
                'description' => '24 hours of learning completed',
                'earned' => ($hoursLearned >= 24),
                'bg' => 'from-blue-50 to-cyan-50',
                'border' => 'border-blue-100',
                'iconBg' => 'from-blue-500 to-cyan-500',
                'iconPath' => 'M13 10V3L4 14h7v7l9-11h-7z',
            ],
            [
                'id' => 'assignment_champ',
                'title' => 'Assignment Champ',
                'description' => 'Completed 5+ assignments',
                'earned' => ($hoursLearned >= 5), // hoursLearned mirrors completed submissions
                'bg' => 'from-green-50 to-emerald-50',
                'border' => 'border-green-100',
                'iconBg' => 'from-green-500 to-emerald-500',
                'iconPath' => 'M5 13l4 4L19 7',
            ],
        ];

        foreach ($possibleAchievements as $ach) {
            if (!empty($ach['earned'])) {
                $achievementsEarned[] = $ach;
            }
        }

        return view('dashboard', compact(
            'user',
            'learner',
            'courses',
            'learner_courses',
            'course',
            'coursesEnrolled',
            'averageProgress',
            'hoursLearned',
            'courseProgress',
            'achievementsEarned'
        ));
        // Compact() = $user => the current value of user etc.
    }

    public function showCourse(Course $course)
    {
        $user = auth()->user();
        $learner = Learner::where('user_id', $user->id)->firstOrFail();

        $isEnrolled = $learner->courses()->where('course_id', $course->id)->exists();

        if (!$isEnrolled) {
            return redirect()->route('dashboard')->with('error', 'You are not enrolled in this course.');
        }

        $course->load(['instructor', 'announcements', 'assignments']);

        // Compute per-course completion percentage for this learner
        $assignmentIds = $course->assignments->pluck('id');
        $totalAssignmentsInCourse = $assignmentIds->count();
        $completedInCourse = 0;
        if ($totalAssignmentsInCourse > 0) {
            $completedInCourse = Submission::where('learner_id', $learner->id)
                ->whereIn('assignment_id', $assignmentIds)
                ->whereIn('status', ['submitted', 'graded'])
                ->count();
        }
        $completionPercentage = $totalAssignmentsInCourse > 0
            ? (int) round(($completedInCourse / $totalAssignmentsInCourse) * 100)
            : 0;

        return view('learners.course-view', compact('course', 'user', 'learner', 'completionPercentage'));
    }

    public function update(Request $request, User $user)
    {
        $learner = Learner::where('user_id', $user->id)->firstOrFail();

        if (!$learner) {
            return redirect()->route('dashboard')->with('error', 'Learner profile not found.');
        }

        if ($request->boolean('unenroll') && $request->filled('course_id'))
        {
            $request->validate([
                'course_id' => 'required|exists:courses,id',
            ]);
            $learner->courses()->detach($request->input('course_id'));
            return redirect()->route('dashboard')->with('success', 'Successfully unenrolled from course.');
        }


        if ($request->filled('course_ids'))
        {
            $request->validate([
                'course_ids' => 'array',
                'course_ids.*' => 'integer|exists:courses,id',
            ]);
            $learner->courses()->syncWithoutDetaching($request->input('course_ids'));
            return redirect()->route('dashboard')->with('success', 'Courses enrolled successfully.');
        }

        if ($request->filled('course_id'))
        {
            $request->validate([
                'course_id' => 'required|exists:courses,id',
            ]);
            $learner->courses()->syncWithoutDetaching([$request->input('course_id')]);
            return redirect()->route('dashboard')->with('success', 'Course enrolled successfully.');
        }

        // Handle profile updates (skill, bio, and profile picture)
        else
        {
            $request->validate([
                'skill' => 'nullable|string|max:255',
                'bio' => 'nullable|string|max:500',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            $learnerData = $request->only(['skill', 'bio']);
            if (!empty($learnerData)) {
                $learner->update($learnerData);
            }

            if ($request->hasFile('profile_picture')) {
                $imageData = file_get_contents($request->file('profile_picture')->getRealPath());
                $user->update(['profile_picture' => $imageData]);
            }

            $learner->update($request->only(['skill', 'bio']));
            return redirect()->route('dashboard')->with('success', 'Profile updated successfully.');
        }
    }

    public function deleteProfilePicture(User $user)
    {
        // Ensure the authenticated user can only delete their own profile picture
        if (auth()->user()->id !== $user->id) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized action.');
        }

        // Remove the profile picture by setting it to null
        $user->update(['profile_picture' => null]);

        return redirect()->route('dashboard')->with('success', 'Profile picture removed successfully.');
    }

}
