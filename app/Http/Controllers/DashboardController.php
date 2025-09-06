<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCompletion;
use App\Models\Learner;
use App\Models\Submission;
use App\Models\User;
use App\Models\UserAchievement;
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

        // Get course completions for grades tab
        $course_completions = null;
        if ($learner) {
            $course_completions = CourseCompletion::with(['course.instructor'])
                ->where('learner_id', $learner->id)
                ->orderBy('completed_at', 'desc')
                ->get();
        }

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

        // --- Persistent Achievements ---
        $userStats = [
            'coursesEnrolled' => $coursesEnrolled,
            'hoursLearned' => $hoursLearned,
            'averageProgress' => $averageProgress,
            'totalSubmissions' => $completedSubmissions,
        ];

        // Check and award new achievements
        $this->checkAndAwardAchievements($user->id, $userStats);

        // Get all earned achievements (persistent)
        $achievementsEarned = $this->getUserAchievements($user->id);

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
            'achievementsEarned',
            'course_completions'
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

            // Check for completed courses
            $completedCourseIds = CourseCompletion::where('learner_id', $learner->id)
                ->whereIn('course_id', $request->input('course_ids'))
                ->pluck('course_id')
                ->toArray();

            if (!empty($completedCourseIds)) {
                $completedCourses = Course::whereIn('id', $completedCourseIds)->pluck('title')->toArray();
                return redirect()->route('dashboard')->with('error',
                    'Cannot re-enroll in completed courses: ' . implode(', ', $completedCourses));
            }

            $learner->courses()->syncWithoutDetaching($request->input('course_ids'));
            return redirect()->route('dashboard')->with('success', 'Courses enrolled successfully.');
        }

        if ($request->filled('course_id'))
        {
            $request->validate([
                'course_id' => 'required|exists:courses,id',
            ]);

            // Check if course is already completed
            $isCompleted = CourseCompletion::where('learner_id', $learner->id)
                ->where('course_id', $request->input('course_id'))
                ->exists();

            if ($isCompleted) {
                $course = Course::find($request->input('course_id'));
                return redirect()->route('dashboard')->with('error',
                    'Cannot re-enroll in completed course: ' . $course->title);
            }

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

    /**
     * Check and award achievements based on current user stats
     */
    private function checkAndAwardAchievements(int $userId, array $stats): array
    {
        $awardedAchievements = [];
        $possibleAchievements = UserAchievement::getPossibleAchievements();

        foreach ($possibleAchievements as $achievement) {
            $achievementId = $achievement['id'];

            // Check if user already has this achievement
            $hasAchievement = UserAchievement::where('user_id', $userId)
                ->where('achievement_id', $achievementId)
                ->exists();

            if ($hasAchievement) {
                continue;
            }

            // Check if user meets the criteria for this achievement
            $shouldAward = $this->checkAchievementCriteria($achievementId, $stats);

            if ($shouldAward) {
                $awarded = UserAchievement::awardAchievement($userId, $achievementId);
                if ($awarded) {
                    $awardedAchievements[] = $awarded;
                }
            }
        }

        return $awardedAchievements;
    }

    /**
     * Check if user meets criteria for a specific achievement
     */
    private function checkAchievementCriteria(string $achievementId, array $stats): bool
    {
        switch ($achievementId) {
            case 'getting_started':
                return ($stats['coursesEnrolled'] > 0) ||
                       ($stats['hoursLearned'] > 0) ||
                       ($stats['averageProgress'] > 0);

            case 'course_explorer':
                return $stats['coursesEnrolled'] >= 3;

            case 'high_achiever':
                return $stats['averageProgress'] >= 75;

            case 'consistent':
                return $stats['hoursLearned'] >= 24;

            case 'assignment_champ':
                return $stats['hoursLearned'] >= 5; // hoursLearned mirrors completed submissions

            default:
                return false;
        }
    }

    /**
     * Get all earned achievements for a user (both current and historical)
     */
    private function getUserAchievements(int $userId): array
    {
        $earnedAchievements = UserAchievement::where('user_id', $userId)
            ->orderBy('earned_at', 'desc')
            ->get()
            ->toArray();

        // Convert to the format expected by the dashboard
        return array_map(function ($achievement) {
            return [
                'id' => $achievement['achievement_id'],
                'title' => $achievement['title'],
                'description' => $achievement['description'],
                'bg' => $achievement['bg_class'],
                'border' => $achievement['border_class'],
                'iconBg' => $achievement['icon_bg_class'],
                'iconPath' => $achievement['icon_path'],
                'earned' => true,
                'earned_at' => $achievement['earned_at'],
            ];
        }, $earnedAchievements);
    }

}
